<?php

namespace Database\Seeders;

use App\Models\Algo;
use Illuminate\Database\Seeder;

class AlgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $winnowing = Algo::create([
            'name' => 'Winnowing',
            'about' => 'Algorithme de détection de plagiat basé sur les empreintes numériques de documents (Digital Fingerprinting).',
        ]);

        $winnowing->props()->createMany([
            ['name' => 'k', 'about' => 'k-gram size', 'default_value' => '50'],
            ['name' => 'w', 'about' => 'window size', 'default_value' => '100'],
        ]);

        $jaccard = Algo::create([
            'name' => 'Jaccard',
            'about' => 'Détection de plagiat utilisant des filtres de Bloom pour une comparaison probabiliste rapide.',
        ]);

        $jaccard->props()->createMany([
            ['name' => 'c', 'about' => 'hash count', 'default_value' => '1'],
            ['name' => 's', 'about' => 'bit array size', 'default_value' => '1024'],
        ]);
    }
}
