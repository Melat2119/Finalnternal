<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('documents')->insert([
            [
                'title' => 'User Guide',
                'content' => 'Comprehensive user guide for OmishtuJoy CRM.',
                'filePath' => 'docs/user_guide.pdf',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Release Notes',
                'content' => 'Release notes for version 2.0.',
                'filePath' => 'docs/release_notes.pdf',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Training Manual',
                'content' => 'Training manual for new employees.',
                'filePath' => 'docs/training_manual.pdf',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
