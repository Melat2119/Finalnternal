<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentServicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('document_services')->insert([
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
