<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>bookmarklet gen demo - PHP script to convert Javascript into bookmarklet links</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
    <h1><a href="https://github.com/ozh/bookmarkletgen">bookmarklet gen</a> demo</h1>
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
        include dirname( __DIR__ ) . '/src/Bookmarkletgen.php';
        $book = new \Ozh\Bookmarkletgen\Bookmarkletgen;
        $link = $book->crunch( $post );
        printf( '<p>Test your bookmarklet: <a href="%s">bookmarklet</a></p>', $link );
        ?>

    <?php } ?>
    
    </div>

</body>
</html>