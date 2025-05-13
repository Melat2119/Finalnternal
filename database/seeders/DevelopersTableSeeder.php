<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Developer;
use Illuminate\Support\Facades\DB;

class DevelopersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Developer::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Developer::insert([
            ['name' => 'Alice Dev', 'email' => 'alice.dev@example.com'],
            ['name' => 'Bob Dev', 'email' => 'bob.dev@example.com'],
            ['name' => 'Charlie Dev', 'email' => 'charlie.dev@example.com'],
        ]);
    }
}
