<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'OmishtuJoy CRM',
                'description' => 'Customer Relationship Management software.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'OmishtuJoy ERP',
                'description' => 'Enterprise Resource Planning solution.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'OmishtuJoy Analytics',
                'description' => 'Business analytics and reporting tool.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
