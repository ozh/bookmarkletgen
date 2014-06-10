# bookmarklet gen

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

- wraps code into a self invoking function ready for bookmarking

This is basically a slightly enhanced PHP port of the excellent Bookmarklet Crunchinator
http://ted.mielczarek.org/code/mozilla/bookmarklet.html

