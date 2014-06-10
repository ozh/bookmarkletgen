<?php

/**
 * BookmarkletGen : converts readable Javascript code into a bookmarklet link
 *
 * Example:
 * function someName( param ) { alert( "this is a string" ) }
 * will return:
 * function%20someName(param){alert("this is a string")}
 *
 */
class BookmarkletGen {

    private $literal_strings = array();
    
    private function __construct__() {}
    
    public function crunch( $code ) {
        $out = $code = "(function() {\n" . $code . "\n})();";

        $out = $this->replace_strings( $out );
        $out = $this->kill_comments( $out );
        $out = $this->compress_white_space( $out );
        $out = $this->combine_strings( $out );
        $out = $this->restore_strings( $out );
        $out = $this->encodeURIComponent( $out );
        $out = 'javascript:' . $out;

        return $out;
    }
    
    
    // http://stackoverflow.com/a/1734255/36850
    private function encodeURIComponent($str) {
        $revert = array(
            '%21'=>'!', '%2A'=>'*', '%28'=>'(', '%29'=>')',
        );
    
        return strtr(rawurlencode($str), $revert);
    }

    // Kill comment lines and blocks
    private function kill_comments( $code ) {
        $code = preg_replace( '!\s*//.+$!m', '', $code );
        $code = preg_replace( '!/\*.+?\*/!sm', '', $code ); // s modifier: dot matches new lines
        
        return $code;
    }
    
    /**
     * Compress white space
     *
     * @since
     * @param string $var Stuff
     * @return string Result
     */
    
    private function compress_white_space( $code ) {
        // Tabs to space, no more than 1 consecutive space
        $code = preg_replace( '!\t!m', ' ', $code );
        $code = preg_replace( '![ ]{2,}!m', ' ', $code );
        
        // Remove uneccessary white space around operators, braces and brackets.
        // \xHH sequence is: !%&()*+,-/:;<=>?[]\{|}~
        $code = preg_replace( '/\s([\x21\x25\x26\x28\x29\x2a\x2b\x2c\x2d\x2f\x3a\x3b\x3c\x3d\x3e\x3f\x5b\x5d\x5c\x7b\x7c\x7d\x7e])/m', "$1", $code );
        $code = preg_replace( '/([\x21\x25\x26\x28\x29\x2a\x2b\x2c\x2d\x2f\x3a\x3b\x3c\x3d\x3e\x3f\x5b\x5d\x5c\x7b\x7c\x7d\x7e])\s/m', "$1", $code );
        
        // Split on each line, trim leading/trailing white space, kill empty lines, combine everything in one line
        $code = preg_split( '/\r\n|\r|\n/', $code );
        foreach( $code as $i => $line ) {
            $code[ $i ] = trim( $line );
        }
        $code = implode( '', $code );

        return $code;
    }
    
    
    private function combine_strings( $code ) {
        $code = preg_replace('/"\+"/m', "", $code);
        $code = preg_replace("/'\+'/m", "", $code);

        return $code;
    }

    
    function restore_strings( $code ) {
        foreach( $this->literal_strings as $i => $string ) {
            $code = preg_replace( '/__' . $i . '__/', $string, $code, 1 );
        }
        
        return $code;
    }

    
    private function replace_strings( $code ) {
        $return = "";

        // Split script into individual lines.
        $lines = explode("\n", $code);
        for( $i = 0; $i < count( $lines ); $i++ ) {

            $j = 0;
            $inQuote = false;
            while ($j < strlen( $lines[$i] ) ) {
                $c = $lines[ $i ][ $j ];

                // If not already in a string, look for the start of one.
                if (!$inQuote) {
                    if ($c == '"' || $c == "'") {
                        $inQuote = true;
                        $escaped = false;
                        $quoteChar = $c;
                        $literal = $c;
                    }
                 else
                     $return .= $c;
                }

                // Already in a string, look for end and copy characters.
                else {
                    if ($c == $quoteChar && !$escaped) {
                        $inQuote = false;
                        $literal .= $quoteChar;
                        $return .= "__" . count( $this->literal_strings ) . "__";
                        $this->literal_strings[ count( $this->literal_strings ) ] = $literal;
                    }
                    else if ($c == "\\" && !$escaped)
                        $escaped = true;
                    else
                        $escaped = false;
                    $literal .= $c;
                }
                $j++;
            }
            $return .= "\n";
        }

        return $return;
    }

}
