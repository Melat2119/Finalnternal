<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDocumentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_documets')->insert([
            [
                'id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
