<?php

use Ozh\Bookmarkletgen\Bookmarkletgen;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class Bookmarklet_Test extends TestCase {

    protected Bookmarkletgen $book;

    /**
     * Test a javascript file - return 0 if valid, 1 if invalid (`node --check` exit status code)
     *
     * @param string $js_file
     * @return array
     */
    public function check_js_file(string $js_file): array {
        $cmd = sprintf('%s --check %s 2>&1', NODEJS_BIN, escapeshellarg($js_file));
        exec($cmd, $output, $exit);
        return ['output' => $output, 'exit' => $exit];
    }

    /**
     * Test each javascript
     */
    #[DataProvider('js_snippets')]
    public function test_js_snippet(string $file, ?int $expected_exit_code): void {
        $this->book = new Bookmarkletgen();
        $javascript = file_get_contents($file);

        // Check original javascript file syntax
        $result = $this->check_js_file($file);
        $this->assertSame($expected_exit_code, $result['exit']);;

        // Crunch that snippet into a bookmarklet link
        $link = $this->book->crunch($javascript);

        // Partly un-bookmarkletify for code to be standalone one-liner:
        $link = preg_replace('/^javascript\:/', '', $link);
        $link = rawurldecode($link);

        // Save bookmarklet in a file and check syntax
        $tmp = BM_DATA_DIR.'/crunched_'.basename($file);
        file_put_contents( $tmp, $link);
        $result = $this->check_js_file($tmp);
        $this->assertSame($expected_exit_code, $result['exit']);
        unlink($tmp);
    }

    /**
     * Data provider for test_js_snippet: return an array of js snippets ($file, $expected_output)
     * Expected output is 0 if valid, 1 if invalid
     * @return array
     */
    public static function js_snippets(): array {
        $data = [];

        $files = glob(BM_DATA_DIR . '/*.js');
        foreach ($files as $file) {
            $expected_output = str_contains($file, 'invalid') ? 1 : 0;
            $data[basename($file)] = [$file, $expected_output];
        }

        return $data;
    }

}
