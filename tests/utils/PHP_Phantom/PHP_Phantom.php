<?php

/**
 * Class to test a javascript snippet for syntax error with phantomjs
 *
 * Concept:
 * this class executes the command "phantomjs <test.js> <script_to_test.js>"
 * where
 *  - test.js is a wrapper to add error handling to phantomjs
 *  - script_to_test.js is the script to check
 *
 * Usage :
 *  $phantom = new PHP_Phantom_Test( "path/to/phantomjs", "path/to/test_wrapper.js" );
 *  $code = "alert('some javascript code');";
 *  echo $phantom->test( $code );
 *
 * Output:
 *  nothing if no error detected
 *  error message otherwise
 *
 */
class PHP_Phantom_Test {

    private $phantom;     // path to phantomjs bin
    private $testjs;      // path to phantomjs javascript test wrapper
    
    private $temphandle;  // temp file handle
    private $tempfile;    // path to temp filename

    public function __construct( $bin_path, $testjs_path ) {
        if( !file_exists( $bin_path ) ) {
            die( 'phantomjs binary not found' );
        }
        $this->phantom = $bin_path;
        
        if( !file_exists( $testjs_path ) ) {
            die( 'javascript test wrapper not found' );
        }
        $this->testjs = $testjs_path;
    }
    
    private function create_tempfile( $code ) {
        // create temp file with code
        $this->temphandle = tmpfile();
        fwrite( $this->temphandle, $code );
        
        // get temp file filename
        $meta = stream_get_meta_data( $this->temphandle );
        $this->tempfile = $meta['uri'];        
    }
    
    private function delete_tempfile() {
        fclose( $this->temphandle );
    }
    
    /**
     * Test a JS snippet for syntax error
     *
     * @param string $code  Javascript code
     * @return mixed        nothing if no error, error otherwise
     */
    public function test( $code ) {
        // Create a temp Javascript file with that code
        $this->create_tempfile( $code );
        
        // Start output buffering, call phantomjs, return buffer
        // cd dirname( $this->tempfile ) && $phantom $testjs $tempfile
        $phantom  = escapeshellarg( $this->phantom );
        $testjs   = escapeshellarg( $this->testjs );
        $tempfile = escapeshellarg( $this->tempfile );
        
        // $command = 'cd ' . dirname( $this->tempfile ) . '/ && ' . $this->phantom . ' ' . $this->testjs . ' ' . $this->tempfile;
        $command = $this->phantom . ' ' . $this->testjs . ' ' . $this->tempfile;
        $result = shell_exec( escapeshellcmd( $command ) );
        
        $this->delete_tempfile();

        return $result;
    }

}