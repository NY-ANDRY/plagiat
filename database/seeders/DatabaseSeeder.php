<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            FileExtensionSeeder::class,
            FileTypeSeeder::class,
            UserSeeder::class,
            ExamStatusSeeder::class,
            ExamSeeder::class,
        ]);
    }
}
