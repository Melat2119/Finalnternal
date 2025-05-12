<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Letter;

class LettersTableSeeder extends Seeder
{
    public function run(): void
    {
        Letter::truncate();
        Letter::insert([
            ['subject' => 'Welcome', 'content' => 'Welcome to the company!', 'department' => 'HR', 'status' => 'sent', 'created_by' => 1],
            ['subject' => 'Partnership', 'content' => 'Let\'s partner up.', 'department' => 'Legal', 'status' => 'draft', 'created_by' => 1],
        ]);
    }
}
