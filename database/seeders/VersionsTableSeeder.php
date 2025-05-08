<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VersionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('versions')->insert([
            [
                'name' => 'v1.0',
                'description' => 'Initial release.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'v1.1',
                'description' => 'Minor bug fixes and improvements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'v2.0',
                'description' => 'Major update with new features.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
