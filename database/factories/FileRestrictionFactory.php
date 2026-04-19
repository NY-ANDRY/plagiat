<?php

namespace Database\Factories;

use App\Models\FileExtension;
use App\Models\FileRestriction;
use App\Models\FileType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FileRestriction>
 */
class FileRestrictionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'file_type_id' => FileType::factory(),
            'file_extension_id' => FileExtension::factory(),
            'url_icon' => null,
        ];
    }
}
