<?php

namespace Tests\Feature;

use App\Interface\IProject;
use App\Services\CleaningService;
use Tests\TestCase;
use ZipArchive;

class CleaningServiceTest extends TestCase
{
    private CleaningService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CleaningService;
    }

    public function test_it_correctly_identifies_extensions(): void
    {
        $this->assertEquals('.php', $this->service->getExtension('test.php'));
        $this->assertEquals('.html', $this->service->getExtension('path/to/test.html'));
        $this->assertEquals('.css', $this->service->getExtension('another.test.css'));
    }

    public function test_is_ok_filters_by_extension(): void
    {
        $extensions = [
            ['extension' => '.php'],
            ['extension' => '.html'],
        ];
        $restrictions = [];

        $this->assertTrue($this->service->isOk('test.php', $extensions, $restrictions));
        $this->assertTrue($this->service->isOk('dir/test.html', $extensions, $restrictions));
        $this->assertFalse($this->service->isOk('test.css', $extensions, $restrictions));
        $this->assertFalse($this->service->isOk('dir/', $extensions, $restrictions));
    }

    public function test_is_ok_filters_by_directory_restriction(): void
    {
        $extensions = [['extension' => '.php']];

        $restriction = (object) [
            'name' => 'vendor',
            'fileType' => (object) ['name' => 'dir'],
        ];

        $restrictions = [$restriction];

        $this->assertTrue($this->service->isOk('src/index.php', $extensions, $restrictions));
        $this->assertFalse($this->service->isOk('vendor/autoload.php', $extensions, $restrictions));
        $this->assertFalse($this->service->isOk('src/vendor/test.php', $extensions, $restrictions));
    }

    public function test_is_ok_filters_by_file_restriction(): void
    {
        $extensions = [['extension' => '.php']];

        $restriction = (object) [
            'name' => 'Config.php',
            'fileType' => (object) ['name' => 'file'],
        ];

        $restrictions = [$restriction];

        $this->assertTrue($this->service->isOk('src/index.php', $extensions, $restrictions));
        $this->assertFalse($this->service->isOk('src/Config.php', $extensions, $restrictions));
    }

    public function test_clean_project_processes_zip_correctly(): void
    {
        // Create a temporary zip file
        $zipPath = tempnam(sys_get_temp_dir(), 'test_zip').'.zip';
        $zip = new ZipArchive;
        $zip->open($zipPath, ZipArchive::CREATE);
        $zip->addFromString('index.php', '<?php $a = 1; ?>');
        $zip->addFromString('style.css', 'body { color: red; }');
        $zip->addFromString('ignored.txt', 'some text');
        $zip->addFromString('vendor/excluded.php', '<?php $b = 2; ?>');
        $zip->close();

        $project = \Mockery::mock(IProject::class);
        $project->shouldReceive('getPathname')->andReturn($zipPath);

        $extensions = [
            ['extension' => '.php'],
            ['extension' => '.css'],
        ];

        $restriction = (object) [
            'name' => 'vendor',
            'fileType' => (object) ['name' => 'dir'],
        ];
        $restrictions = [$restriction];

        $result = $this->service->cleanProject($project, $extensions, $restrictions);

        $this->assertStringContainsString('<?php$var=1;?>', $result);
        $this->assertStringContainsString('body{color:red;}', $result);
        $this->assertStringNotContainsString('<?php$var=2;?>', $result);

        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }
}
