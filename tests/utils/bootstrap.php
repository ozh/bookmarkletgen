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
    define( 'BM_PHANTOMJS_BIN', trim( shell_exec( 'which phantomjs' ) ) );

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

// PHPUnit 6 compatibility for previous versions
if ( class_exists( 'PHPUnit\Runner\Version' ) && version_compare( PHPUnit\Runner\Version::id(), '6.0', '>=' ) ) {
    class_alias( 'PHPUnit\Framework\Assert',        'PHPUnit_Framework_Assert' );
    class_alias( 'PHPUnit\Framework\TestCase',      'PHPUnit_Framework_TestCase' );
    class_alias( 'PHPUnit\Framework\Error\Error',   'PHPUnit_Framework_Error' );
    class_alias( 'PHPUnit\Framework\Error\Notice',  'PHPUnit_Framework_Error_Notice' );
    class_alias( 'PHPUnit\Framework\Error\Warning', 'PHPUnit_Framework_Error_Warning' );
}

// Past this point, tests will start
