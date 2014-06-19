<?php

class Syntax_Tests extends PHPUnit_Framework_TestCase {

    function setUp() {
        $this->book    = new \BookmarkletGen;
        $this->phantom = new \PHP_Phantom_Test( BM_PHANTOMJS_BIN, BM_TESTJS );
    }

    /**
     * @dataProvider js_snippets
     */
	public function test_js_snippet( $file, $is_valid ) {
    
        $javascript = file_get_contents( $file );
        
        // Crunch that snippet into a bookmarklet link
        $link = $this->book->crunch( $javascript );
        
        // Partly un-bookmarkletify for code to be standalone one liner:
        $link = preg_replace( '/^javascript\:/', '', $link );
        $link = rawurldecode( $link );
        
        // Check bookmarklet syntax
        if( $is_valid ) {
            $this->assertEquals( '', $this->phantom->test( $link ) );
        } else {
            $this->assertNotEquals( '', $this->phantom->test( $link ) );
        }
	}
    
    public function js_snippets() {
        $data = array();
        
        $files = glob( BM_DATA_DIR . '/*.js' );
        foreach( $files as $file ) {
            $is_valid = strpos( $file, 'invalid' ) === false ? 1 : 0;
            $data[] = array( $file, $is_valid );
        }
        
        return $data;
    }
    
}
