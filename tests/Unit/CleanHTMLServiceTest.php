<?php

namespace Tests\Unit;

use App\Services\Cleaning\CleanHTMLService;
use PHPUnit\Framework\TestCase;

class CleanHTMLServiceTest extends TestCase
{
    private CleanHTMLService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CleanHTMLService;
    }

    public function test_it_removes_whitespace(): void
    {
        $input = "<html>  \n  <body>   </body>\n</html>";
        $expected = '<html><body></body></html>';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_removes_comments(): void
    {
        $input = '<div><!-- comment -->content</div>';
        $expected = '<div>content</div>';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_removes_unclosed_comments_until_end_of_string(): void
    {
        $input = '<div><!-- unclosed comment';
        $expected = '<div>';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_converts_to_lowercase(): void
    {
        $input = '<DIV>CONTENT</DIV>';
        $expected = '<div>content</div>';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_handles_multiple_comments(): void
    {
        $input = '<!-- first -->content<!-- second -->';
        $expected = 'content';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_handles_multiline_comments(): void
    {
        $input = '<div><!-- 
            multiline 
            comment 
        -->content</div>';
        $expected = '<div>content</div>';
        $this->assertEquals($expected, $this->service->clean($input));
    }
}
