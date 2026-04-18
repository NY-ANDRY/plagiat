<?php

namespace Database\Seeders;

use App\Models\ExamStatus;
use Illuminate\Database\Seeder;

class ExamStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamStatus::updateOrCreate(
            ['label' => 'Draft'],
            [
                'description' => 'Exam is being prepared and is not visible to students.',
                'style' => 'primary',
                'is_default' => true,
            ]
        );

        ExamStatus::updateOrCreate(
            ['label' => 'Open'],
            [
                'description' => 'Exam is visible and open for submissions.',
                'style' => 'info',
            ]
        );

        ExamStatus::updateOrCreate(
            ['label' => 'Closed'],
            [
                'description' => 'Exam is closed for submissions.',
                'style' => 'neutral',
            ]
        );
    }
}
