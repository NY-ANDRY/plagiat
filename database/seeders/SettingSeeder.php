<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            [
                'name' => 'input_separator',
                'value' => '--',
                'about' => 'character to separate values from an input',
            ]
        );
    }
}
