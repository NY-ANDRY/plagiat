<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamStatus;
use App\Models\FileExtension;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'a@gmail.com')->first();
        $extensions = FileExtension::all();
        $defaultStatus = ExamStatus::where('is_default', true)->first();
        $openStatus = ExamStatus::where('label', 'Open')->first();

        if ($user && $extensions->isNotEmpty() && $openStatus && $defaultStatus) {
            $exam = Exam::updateOrCreate(
                ['title' => 'Examen web'],
                [
                    'about' => 'le programme doit également stocker cinq entiers dans un tableau afin d’afficher ensuite le plus grand, le plus petit et la moyenne des valeurs, et enfin créer une fonction permettant de vérifier si un nombre est premier ou non, en utilisant les notions de tableaux et de fonctions.',
                    'close_date' => now()->addDays(7),
                    'creator_id' => $user->id,
                ]
            );

            $exam->fileExtensions()->sync($extensions->pluck('id'));

            $exam->statuses()->syncWithPivotValues([$defaultStatus->id], [
                'user_id' => $user->id,
                'created_at' => now(),
            ], false);

            $exam->statuses()->syncWithPivotValues([$openStatus->id], [
                'user_id' => $user->id,
                'created_at' => now()->addMinute(),
            ], false);
        }
    }
}
