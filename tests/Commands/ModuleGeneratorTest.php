<?php

namespace Nwidart\Modules\tests\Commands;

use Nwidart\Modules\Tests\BaseTestCase;

class ModuleGeneratorTest extends BaseTestCase
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $finder;
    /**
     * @var string
     */
    private $modulePath;

    public function setUp()
    {
        parent::setUp();
        $this->modulePath = base_path('modules/Blog');
        $this->finder = $this->app['files'];
    }

    public function tearDown()
    {
        $this->finder->deleteDirectory($this->modulePath);
        parent::tearDown();
    }

    /** @test */
    public function it_generates_module()
    {
        $code = $this->artisan('module:make', ['name' => ['Blog']]);

        $this->assertTrue(is_dir($this->modulePath));
        $this->assertSame(0, $code);
    }

    /** @test */
    public function it_generates_module_folders()
    {
        $this->artisan('module:make', ['name' => ['Blog']]);

        foreach (config('modules.paths.generator') as $directory) {
            $this->assertTrue(is_dir($this->modulePath . '/' . $directory));
        }
    }

    /** @test */
    public function it_generates_module_files()
    {
        $this->artisan('module:make', ['name' => ['Blog']]);

        foreach (config('modules.stubs.files') as $file) {
            $this->assertTrue(is_file($this->modulePath . '/' . $file));
        }
    }

    /** @test */
    public function it_generates_correct_composerjson_file()
    {
        $this->artisan('module:make', ['name' => ['Blog']]);

        $file = $this->finder->get($this->modulePath . '/composer.json');

        $this->assertEquals($this->getExpectedComposerJson(), $file);
    }

    private function getExpectedComposerJson()
    {
        return <<<TEXT
{
	"name": "nwidart/blog",
	"description": "",
	"authors": [
		{
			"name": "Nicolas Widart",
			"email": "n.widart@gmail.com"
		}
	],
	"autoload": {
		"psr-4": {
			"Modules\\\Blog\\\": ""
		}
	}
}

TEXT;
    }
}
