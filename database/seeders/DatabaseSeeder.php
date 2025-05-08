<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Subject;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        Classroom::insert([
            ['name' => 'VII. 1'],
            ['name' => 'VII. 2'],
            ['name' => 'VII. 3'],
            ['name' => 'VIII. 1'],
            ['name' => 'VIII. 2'],
            ['name' => 'VIII. 3'],
            ['name' => 'IX. 1'],
            ['name' => 'IX. 2'],
            ['name' => 'IX. 3'],
        ]);

        Subject::insert([
            ['name' => 'IPA'],
            ['name' => 'IPS'],
            ['name' => 'MATEMATIKA'],
        ]);
    }
}
