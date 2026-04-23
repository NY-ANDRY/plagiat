<?php

namespace Tests\Unit;

use App\Services\Cleaning\CleanCSSService;
use PHPUnit\Framework\TestCase;

class CleanCSSServiceTest extends TestCase
{
    private CleanCSSService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CleanCSSService;
    }

    public function test_it_removes_whitespace(): void
    {
        $input = "body {  color: red;  \n   margin: 0; }";
        $expected = 'body{color:red;margin:0;}';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_removes_comments(): void
    {
        $input = 'body { /* comment */ color: red; }';
        $expected = 'body{color:red;}';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_converts_to_lowercase(): void
    {
        $input = 'BODY { COLOR: RED; }';
        $expected = 'body{color:red;}';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_handles_multiple_comments(): void
    {
        $input = '/* one */body/* two */{color:red;}';
        $expected = 'body{color:red;}';
        $this->assertEquals($expected, $this->service->clean($input));
    }
}
