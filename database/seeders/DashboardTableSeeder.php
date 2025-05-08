<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DashboardTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('dashboards')->insert([
            [
                'title' => 'Welcome Widget',
                'content' => 'Welcome to OmishtuJoy Internal Knowledge System!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Quick Stats',
                'content' => 'Documents: 120, Users: 45, Feedback: 32',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Recent Activity',
                'content' => 'John Doe uploaded a new document.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
