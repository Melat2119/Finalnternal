<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('feedback')->insert([
            [
                'document_id' => 1,
                'product_id' => 1,
                'service_id' => 1,
                'message' => 'Very helpful document, thanks!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'document_id' => 2,
                'product_id' => 2,
                'service_id' => 2,
                'message' => 'Please update the release notes for the latest version.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'document_id' => 3,
                'product_id' => 3,
                'service_id' => 3,
                'message' => 'The training manual is clear and easy to follow.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
