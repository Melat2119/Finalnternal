<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Socialmediamanager;

class SocialmediamanagersTableSeeder extends Seeder
{
    public function run(): void
    {
        Socialmediamanager::truncate();
        Socialmediamanager::insert([
            ['name' => 'Ivan Social', 'email' => 'ivan.social@example.com'],
            ['name' => 'Judy Social', 'email' => 'judy.social@example.com'],
        ]);
    }
}
