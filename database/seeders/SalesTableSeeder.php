<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;

class SalesTableSeeder extends Seeder
{
    public function run(): void
    {
        Sale::truncate();
        Sale::insert([
            ['name' => 'Alice Sales', 'email' => 'alice.sales@example.com'],
            ['name' => 'Bob Sales', 'email' => 'bob.sales@example.com'],
        ]);
    }
}
