<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuditLogSeeder extends Seeder
{
    public function run()
    {
        $users = ['Alice', 'Bob', 'Charlie', 'Diana', 'Manager1', 'Director'];
        $actions = ['login', 'upload', 'approve', 'delete', 'update', 'logout'];
        $descriptions = [
            'Logged in to the system',
            'Uploaded a document',
            'Approved a document',
            'Deleted a record',
            'Updated profile information',
            'Logged out of the system',
            'Unauthorized access attempt detected',
            'Changed password',
            'Viewed audit logs'
        ];

        for ($i = 1; $i <= 30; $i++) {
            DB::table('audit_logs')->insert([
                'user' => $users[array_rand($users)],
                'action' => $actions[array_rand($actions)],
                'description' => $descriptions[array_rand($descriptions)],
                'timestamp' => Carbon::now()->subMinutes(rand(0, 1440)),
                'ip_address' => '192.168.1.' . rand(1, 100),
            ]);
        }
    }
}
