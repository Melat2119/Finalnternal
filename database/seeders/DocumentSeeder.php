<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('documents')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $departments = ['HR', 'Finance', 'IT', 'Marketing'];
        $types = ['contract', 'report', 'proposal', 'manual'];
        $statuses = ['approved', 'pending', 'rejected'];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('documents')->insert([
                'title' => "Document $i",
                'department' => $departments[array_rand($departments)],
                'type' => $types[array_rand($types)],
                'file_path' => "/storage/documents/document_$i.pdf",
                'uploaded_by' => rand(1, 3), // Example user/developer IDs
                'status' => $statuses[array_rand($statuses)],
                'approved_by' => rand(1, 3),
                'approval_comment' => "Comment for document $i",
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
