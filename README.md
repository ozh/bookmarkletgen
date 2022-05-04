# Bookmarklet Gen 

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/dd062b0223c647d8bb297bf036343d34)](https://app.codacy.com/gh/ozh/bookmarkletgen?utm_source=github.com&utm_medium=referral&utm_content=ozh/bookmarkletgen&utm_campaign=Badge_Grade_Settings)

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

## Installation

If you are using Composer, add this requirement to your `composer.json` file and run `composer install`:

    {
        "require": {
            "ozh/bookmarkletgen": "1.2.0"
        }
    }

Or simply in the command line : `composer install ozh/bookmarkletgen`

If you're not using composer, download the class file and include it manually.

## Example

```php
<?php
$javascript = <<<CODE
var link="http://google.com/"; // destination
window.location = link;
CODE;

require 'vendor/autoload.php'; // if you install using Composer
require 'path/to/Bookmarkletgen.php'; // otherwise

$book = new \Ozh\Bookmarkletgen\Bookmarkletgen;
$link = $book->crunch( $javascript );

printf( '<a href="%s">bookmarklet</a>', $link );
```

will print:

```html
<a href="javascript:(function()%7Bvar%20link%3D%22http%3A%2F%2Fgoogle.com%2F%22%3Bwindow.location%3Dlink%3B%7D)()%3B">bookmarklet</a>
```

## Tests

This library comes with unit tests to make sure the resulting crunched Javascript is valid code.

Current version supports PHP 7.2+ (Previous releases were tested with PHP 5.6 - 7.1)

## License

Do whatever the hell you want to do with it
