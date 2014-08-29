<?php
/**
 * Load everything needed
 */
define( 'BM_ROOTDIR', str_replace( '\\', '/', dirname( dirname( __DIR__ ) ) ) );
require_once BM_ROOTDIR . '/tests/utils/PHP_Phantom/PHP_Phantom.php';
require_once BM_ROOTDIR . '/src/BookmarkletGen.php';

// Get phantomjs path into constant PHANTOMJS_BIN

// In Travis? 
if( defined( 'BM_TRAVIS_TESTSUITE' ) && BM_TRAVIS_TESTSUITE ) {
    define( 'BM_PHANTOMJS_BIN', 'phantomjs' );

// Not in Travis?
} else {
    if( defined( 'BM_CUSTOM_PHANTOMJS_PATH' ) ) {
        if( BM_CUSTOM_PHANTOMJS_PATH === false ) {
            $phantom = trim( shell_exec( 'which phantomjs' ) );
        } else {
            $phantom = BM_CUSTOM_PHANTOMJS_PATH;
        }
        if( !file_exists( $phantom ) ) {
            die( 'phantomjs not found or not in path' );
        }
        define( 'BM_PHANTOMJS_BIN', $phantom );
    }
}

// Path to phantomjs Javascript testing script
define( 'BM_TESTJS', BM_ROOTDIR . '/tests/utils/PHP_Phantom/test.js' );

// Path to data dir containing JS snippets
define( 'BM_DATA_DIR', BM_ROOTDIR . '/tests/data' );

// Past this point, tests will start

