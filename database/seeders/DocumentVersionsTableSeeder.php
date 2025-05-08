<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentVersionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('documents_versions')->insert([
            [
                'version_number' => '1.0',
                'changes' => 'Initial version.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'version_number' => '1.1',
                'changes' => 'Minor updates.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
