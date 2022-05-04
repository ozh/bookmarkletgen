<?php
/**
 * Load everything needed
 */
define( 'BM_ROOTDIR', str_replace( '\\', '/', dirname( dirname( __DIR__ ) ) ) );
require_once BM_ROOTDIR . '/tests/utils/PHP_Phantom/PHP_Phantom.php';
require_once BM_ROOTDIR . '/src/Ozh/Bookmarkletgen/Bookmarkletgen.php';

// phantomjs in path or manually set in phpunit.xml
if (!defined('PHANTOMJS_BIN')) {
    $phantomjs_path = exec('which phantomjs');
    if ($phantomjs_path) {
        define('PHANTOMJS_BIN', $phantomjs_path);
    } else {
        throw new Exception('Phantomjs not found in path');
    }
}

// Path to phantomjs Javascript testing script
define( 'BM_TESTJS', BM_ROOTDIR . '/tests/utils/PHP_Phantom/test.js' );

// Path to data dir containing JS snippets
define( 'BM_DATA_DIR', BM_ROOTDIR . '/tests/data' );
