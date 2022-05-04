<?php


use Ozh\Bookmarkletgen\Bookmarkletgen;

class Syntax_Test extends PHPUnit\Framework\TestCase {

    protected $book;
    protected $phantom;

    /**
     * @dataProvider js_snippets
     */
	public function test_js_snippet( $file, $is_valid ) {

        $this->book    = new Bookmarkletgen;
        $this->phantom = new \PHP_Phantom_Test( PHANTOMJS_BIN, BM_TESTJS );
    
        $javascript = file_get_contents( $file );
        
        // Crunch that snippet into a bookmarklet link
        $link = $this->book->crunch( $javascript );
        
        // Partly un-bookmarkletify for code to be standalone one liner:
        $link = preg_replace( '/^javascript\:/', '', $link );
        $link = rawurldecode( $link );
        
        // Check bookmarklet syntax
        if( $is_valid ) {
            $this->assertSame( 'true', trim($this->phantom->test( $link )) );
        } else {
            $this->assertNull( $this->phantom->test( $link ) );
        }
	}

    /**
     * Data provider for test_js_snippet : return array of js snippets ($file, $is_valid)
     */
    public function js_snippets() {
        $data = array();

        $files = glob( BM_DATA_DIR . '/*.js' );
        foreach( $files as $file ) {
            $is_valid = strpos( $file, 'invalid' ) === false ? 1 : 0;
            $data[basename($file)] = array( $file, $is_valid );
        }
        
        return $data;
    }
    
}
