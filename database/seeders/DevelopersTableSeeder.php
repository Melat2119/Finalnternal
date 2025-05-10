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

        // Truncate the developers table
        DB::table('developers')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Developer::insert([
            ['name' => 'Eve Dev', 'email' => 'eve.dev@example.com'],
            ['name' => 'Frank Dev', 'email' => 'frank.dev@example.com'],
        ]);
    }
}
