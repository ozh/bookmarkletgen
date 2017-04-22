/**
 * This script uses PhantomJS to check a script syntax
 *
 * Usage:
 *  phantomjs test.js path/to/script_to_test.js
 *
 * Output:
 *  nothing if no syntax error detected
 *  error message otherwise
 *
 * For the record: Why not simply use NodeJS?
 * Because alert() isn't available in node, it's a a property of browser window objects.
 */

// Workaround for https://github.com/ariya/phantomjs/issues/12697 on phantomjs 1.9.8
phantomExit = function(exitCode) {
    page.close();
    setTimeout(function() { phantom.exit(exitCode); }, 0);
};

var system = require('system'),
    fs = require('fs');

// Get arguments
if( system.args.length === 1 ) {
    console.log('Missing argument: filename of script to test');
    phantomExit(1);
}
var to_test=system.args[1];

// Check that script to test exists
if( !fs.isFile(to_test) || !fs.isReadable(to_test) ) {
    console.log('Cannot read script '+to_test);
    phantomExit(1);
}

// Define error handler with an exit at the end
phantom.onError = function(msg, trace) {
    var msgStack = ['JAVASCRIPT ERROR: ' + msg];
    if (trace && trace.length) {
        msgStack.push('TRACE:');
        trace.forEach(function(t) {
            msgStack.push(' -> ' + (t.file || t.sourceURL) + ': ' + t.line + (t.function ? ' (in function ' + t.function + ')' : ''));
        });
    }
    console.error(msgStack.join('\n'));
    phantomExit(1);
};

// Now run the real code and exit
phantom.injectJs(to_test);
phantomExit(0);
