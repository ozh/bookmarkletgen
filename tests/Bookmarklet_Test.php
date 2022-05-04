<?php


use Ozh\Bookmarkletgen\Bookmarkletgen;

class Syntax_Test extends PHPUnit\Framework\TestCase {

    protected $book;
    protected $phantom;

    /**
     * Test each javascript
     *
     * @dataProvider js_snippets
     */
	public function test_js_snippet( $file, $expected_output ) {

        $this->book    = new Bookmarkletgen;
        $this->phantom = new \PHP_Phantom_Test( PHANTOMJS_BIN, BM_TESTJS );
    
        $javascript = file_get_contents( $file );

        // Check original javascript
        $this->assertSame( $expected_output, $this->phantom->test( $javascript ) );

        // Crunch that snippet into a bookmarklet link
        $link = $this->book->crunch( $javascript );
        
        // Partly un-bookmarkletify for code to be standalone one liner:
        $link = preg_replace( '/^javascript\:/', '', $link );
        $link = rawurldecode( $link );
        
        // Check bookmarklet syntax
        $this->assertSame( $expected_output, $this->phantom->test( $link ) );
	}

    /**
     * Data provider for test_js_snippet : return array of js snippets ($file, $expected_output)
     */
    public function js_snippets() {
        $data = array();

        $files = glob( BM_DATA_DIR . '/*.js' );
        foreach( $files as $file ) {
            $expected_output = strpos( $file, 'invalid' ) === false ? "true\n" : null;
            $data[basename($file)] = array( $file, $expected_output );
        }
        
        return $data;
    }
    
}
