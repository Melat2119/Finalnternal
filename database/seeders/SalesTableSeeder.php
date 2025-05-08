<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale; // changed from Sales to Sale

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

// Run this command in your terminal to seed the database:
// php artisan db:seed --class=SalesTableSeeder
