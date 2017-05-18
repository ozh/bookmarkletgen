<?php

$javascript = <<<CODE
a="http://héhé.fr"; // this is a comment

// Let's define a function
// that's a "literal string quoted" in a comment
function pop_it( val ) {
	alert ( 'this is a "test" my dear: ' + val + " is the value !" );
}
/*
multi line comments
should be killed too
*/
pop_it( a );       // lots of spaces before and after          
CODE;

include dirname( __DIR__ ) . '/src/Ozh/Bookmarkletgen/Bookmarkletgen.php';
$book = new \Ozh\Bookmarkletgen\Bookmarkletgen;
$link = $book->crunch( $javascript );

printf( '<a href="%s">bookmarklet</a>', $link );

