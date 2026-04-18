<?php

namespace Database\Seeders;

use App\Models\FileExtension;
use Illuminate\Database\Seeder;

class FileExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FileExtension::updateOrCreate(
            [
                'name' => 'html',
                'extension' => '.html',
                'url_icon' => 'ext/html.svg',
            ]
        );
        FileExtension::updateOrCreate(
            [
                'name' => 'css',
                'extension' => '.css',
                'url_icon' => 'ext/css.svg',
            ]
        );
        FileExtension::updateOrCreate(
            [
                'name' => 'php',
                'extension' => '.php',
                'url_icon' => 'ext/php.svg',
            ]
        );
    }
}
