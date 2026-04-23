<?php

namespace Tests\Unit;

use App\Services\Cleaning\CleanPHPService;
use PHPUnit\Framework\TestCase;

class CleanPHPServiceTest extends TestCase
{
    private CleanPHPService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CleanPHPService;
    }

    public function test_it_removes_whitespace(): void
    {
        $input = "<?php  \n  echo 'hello';   ?>";
        $expected = "<?phpecho'hello';?>";
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_removes_single_line_comments(): void
    {
        $input = "<?php // comment \n echo 'hello'; ?>";
        $expected = "<?phpecho'hello';?>";
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_removes_multi_line_comments(): void
    {
        $input = "<?php /* comment */ echo 'hello'; ?>";
        $expected = "<?phpecho'hello';?>";
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_renames_variables(): void
    {
        $input = '<?php $myVar = 1; $anotherVar = 2; return $myVar + $anotherVar; ?>';
        // The service replaces variable names with 'var'.
        // So "$myVar" becomes "$var", "$anotherVar" becomes "$var"
        $expected = '<?php$var=1;$var=2;return$var+$var;?>';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_renames_variables_with_complex_names(): void
    {
        $input = '<?php $user_id = 1; $UserName = "test"; ?>';
        $expected = '<?php$var=1;$var="test";?>';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_it_handles_multiple_different_comments(): void
    {
        $input = "<?php \n // line comment \n /* block \n comment */ \n \$a = 1; ?>";
        $expected = '<?php$var=1;?>';
        $this->assertEquals($expected, $this->service->clean($input));
    }

    public function test_is_whitespace_works(): void
    {
        $this->assertTrue($this->service->isWhitespace("  \n \r\n \t "));
        $this->assertFalse($this->service->isWhitespace(' a '));
    }

    public function test_rename_vars_regex_works(): void
    {
        $input = '<?php $foo = $bar; ?>';
        $expected = '<?php $var = $var; ?>'; // Regex version doesn't strip spaces as it's a sub-step
        $this->assertEquals($expected, $this->service->renameVarsRegex($input));
    }
}
