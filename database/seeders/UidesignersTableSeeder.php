<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Uidesigner;

class UidesignersTableSeeder extends Seeder
{
    public function run(): void
    {
        Uidesigner::truncate();
        Uidesigner::insert([
            ['name' => 'Charlie UI', 'email' => 'charlie.ui@example.com'],
            ['name' => 'Dana UI', 'email' => 'dana.ui@example.com'],
        ]);
    }
}
