# bookmarklet gen

Convert readable Javascript code into bookmarklet links

## Features

- removes comments

- compresses code, not literal strings
  Example:
    ```javascript
  function someName( param ) { alert( "this is a string" ) }
    ```
  will return:
    ```javascript
  function%20someName(param){alert("this is a string")}
    ```

- wraps code into a self invoking function

This is basically a slightly enhanced PHP port of the excellent Bookmarklet Crunchinator
http://ted.mielczarek.org/code/mozilla/bookmarklet.html

