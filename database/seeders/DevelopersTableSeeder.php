<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Developer;

class DevelopersTableSeeder extends Seeder
{
    public function run(): void
    {
        Developer::truncate();
        Developer::insert([
            ['name' => 'Eve Dev', 'email' => 'eve.dev@example.com'],
            ['name' => 'Frank Dev', 'email' => 'frank.dev@example.com'],
        ]);
    }
}
