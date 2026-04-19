<?php

namespace Database\Seeders;

use App\Models\FileType;
use Illuminate\Database\Seeder;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FileType::updateOrCreate(
            ['name' => 'file'],
            ['url_icon' => 'file/file.svg']
        );

        FileType::updateOrCreate(
            ['name' => 'dir'],
            ['url_icon' => 'file/folder.svg']
        );
    }
}
