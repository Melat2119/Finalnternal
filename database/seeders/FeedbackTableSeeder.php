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
                'developer_id' => 1,
                'message' => 'Very helpful document, thanks!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'developer_id' => 2,
                'message' => 'Please update the release notes for the latest version.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'developer_id' => 1,
                'message' => 'The training manual is clear and easy to follow.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
