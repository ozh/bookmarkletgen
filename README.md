# Bookmarklet Gen [![](https://travis-ci.org/ozh/bookmarkletgen.svg?branch=master)](https://travis-ci.org/ozh/bookmarkletgen)

Convert readable Javascript code into bookmarklet links

## Features

- removes comments

- compresses code by removing extraneous spaces, but not within literal strings.
  Example:
    ```javascript
  function   someName(   param   ) {
     alert( "this is a string" )
  }
    ```
  will return:
    ```javascript
  function%20someName(param){alert("this%20is%20a%20string")}
    ```
- encodes what needs to be encoded

- wraps code into a self invoking function ready for bookmarking

This is basically a slightly enhanced PHP port of the excellent Bookmarklet Crunchinator: 
http://ted.mielczarek.org/code/mozilla/bookmarklet.html

## Example

```php
$javascript = <<<CODE
var link="http://google.com/"; // destination
window.location = link;
CODE;

$book = new BookmarkletGen;
$link = $book->crunch( $javascript );

printf( '<a href="%s">bookmarklet</a>', $link );
```

will print:

```html
<a href="javascript:(function()%7Bvar%20link%3D%22http%3A%2F%2Fgoogle.com%2F%22%3Bwindow.location%3Dlink%3B%7D)()%3B">bookmarklet</a>
```

Which is: <a href="javascript:(function()%7Bvar%20link%3D%22http%3A%2F%2Fgoogle.com%2F%22%3Bwindow.location%3Dlink%3B%7D)()%3B">bookmarklet</a>

## Tests

This library comes with unit tests to make sure the resulting crunched Javascript is valid code.

## License

Do whatever the hell you want to do with it




