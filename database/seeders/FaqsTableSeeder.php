<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('f_a_q_s')->insert([
            [
                'product_id' => 1,
                'service_id' => 1,
                'question' => 'How do I reset my password?',
                'answer' => 'Go to your profile settings and click on "Reset Password".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'service_id' => 2,
                'question' => 'How do I contact support?',
                'answer' => 'You can contact support via the support page or email.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'service_id' => 3,
                'question' => 'Where can I find training materials?',
                'answer' => 'Training materials are available in the resources section.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
