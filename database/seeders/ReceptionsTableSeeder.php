<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reception;

class ReceptionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Reception::truncate();
        Reception::insert([
            ['name' => 'Grace Reception', 'email' => 'grace.reception@example.com'],
            ['name' => 'Heidi Reception', 'email' => 'heidi.reception@example.com'],
        ]);
    }
}
