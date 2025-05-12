<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        $departments = ['HR', 'Finance', 'IT', 'Marketing'];
        $users = ['Alice', 'Bob', 'Charlie', 'Diana'];
        $statuses = ['approved', 'pending', 'rejected'];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('documents')->insert([
                'title' => "Document $i",
                'department' => $departments[array_rand($departments)],
                'uploaded_by' => $users[array_rand($users)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
