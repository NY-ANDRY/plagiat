<?php

namespace Database\Factories;

use App\Models\Plagiarism;
use App\Models\PlagiarismStatut;
use App\Models\PlagiarismStatutHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlagiarismStatutHistory>
 */
class PlagiarismStatutHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plagiarism_id' => Plagiarism::factory(),
            'plagiarism_statut_id' => PlagiarismStatut::factory(),
        ];
    }
}
