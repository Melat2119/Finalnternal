<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'General',
                'description' => 'General documentation and resources.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Technical',
                'description' => 'Technical documents and manuals.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HR',
                'description' => 'Human resources policies and forms.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
