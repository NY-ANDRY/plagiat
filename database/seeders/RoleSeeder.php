<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['name' => 'prof'], ['description' => 'Professeur']);
        Role::updateOrCreate(['name' => 'student'], ['description' => 'Étudiant']);
    }
}
