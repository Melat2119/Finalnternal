<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class DocumentsTableSeeder extends Seeder
{
    public function run(): void
    {
        Document::truncate();
        Document::insert([
            ['name' => 'Project Plan', 'department' => 'IT', 'status' => 'active', 'created_by' => 1],
            ['name' => 'Budget Report', 'department' => 'Finance', 'status' => 'pending', 'created_by' => 1],
        ]);
    }
}
