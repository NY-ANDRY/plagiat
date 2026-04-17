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
        $extensions = ['.php', '.html', '.css'];

        foreach ($extensions as $extension) {
            FileExtension::updateOrCreate(['name' => $extension]);
        }
    }
}
