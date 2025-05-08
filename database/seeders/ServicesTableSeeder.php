<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->insert([
            [
                'name' => 'Consulting',
                'description' => 'Professional consulting services for clients.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Support',
                'description' => 'Customer and technical support services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Training',
                'description' => 'Employee and client training programs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
