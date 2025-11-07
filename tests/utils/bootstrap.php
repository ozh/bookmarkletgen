<?php
/**
 * Load everything needed
 */
define( 'BM_ROOTDIR', str_replace( '\\', '/', dirname(__DIR__, 2)) );
require_once BM_ROOTDIR . '/src/Bookmarkletgen.php';

// Node.js must be in the path or manually set in phpunit.xml
if (!defined('NODEJS_BIN')) {
    $nodejs_path = exec('which node');
    if ($nodejs_path) {
        define('NODEJS_BIN', $nodejs_path);
    } else {
        throw new Exception('node not found in path');
    }
}

// Path to data dir containing JS snippets
define( 'BM_DATA_DIR', BM_ROOTDIR . '/tests/data' );
