<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>bookmarklet gen demo - PHP script to convert Javascript into bookmarklet links</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <a href="https://github.com/ozh/bookmarkletgen"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/e7bbb0521b397edbd5fe43e7f760759336b5e05f/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677265656e5f3030373230302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png"></a>

    <div class="container">
    <h1>bookmarklet gen demo</h1>
    <h2>PHP script to convert Javascript into bookmarklet links</h2>

    <?php 
        $post = isset( $_POST['code'] ) ? $_POST['code'] : '';
    ?>

    <hr/>
    <form role="form" method="post">
        <div class="form-group">
            <p>Enter Javascript text to crunch into a bookmarklet link</p>
            <textarea class="form-control" cols="80" rows="10" name="code"><?php echo htmlentities( $post ); ?></textarea>
        </div>
    <button type="submit" class="btn btn-success">Crunch</button>
    </form>

    <?php if( $post ) { ?>

        <hr/>

        <?php
        include dirname( __DIR__ ) . '/src/Ozh/Bookmarkletgen/Bookmarkletgen.php';
        $book = new \Ozh\Bookmarkletgen\Bookmarkletgen;
        $link = $book->crunch( $post );
        printf( '<p>Test your bookmarklet: <a href="%s">bookmarklet</a></p>', $link );
        ?>

    <?php } ?>
    
    </div>

</body>
</html>