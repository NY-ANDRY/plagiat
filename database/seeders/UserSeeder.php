<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profRole = Role::where('name', 'prof')->first();
        $studentRole = Role::where('name', 'student')->first();

        // User A
        $userA = User::updateOrCreate(
            ['email' => 'a@gmail.com'],
            ['name' => 'User A', 'password' => Hash::make('aaaaaaaa')]
        );
        $userA->roles()->syncWithoutDetaching([$profRole->id, $studentRole->id]);

        // User B
        $userB = User::updateOrCreate(
            ['email' => 'b@gmail.com'],
            ['name' => 'User B', 'password' => Hash::make('bbbbbbbb')]
        );
        $userB->roles()->syncWithoutDetaching([$profRole->id]);

        // User C
        $userC = User::updateOrCreate(
            ['email' => 'c@gmail.com'],
            ['name' => 'User C', 'password' => Hash::make('cccccccc')]
        );
        $userC->roles()->syncWithoutDetaching([$studentRole->id]);
    }
}
