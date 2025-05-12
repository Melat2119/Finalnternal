<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;

class AuditLogsTableSeeder extends Seeder
{
    public function run(): void
    {
        AuditLog::truncate();
        AuditLog::insert([
            ['user_id' => 1, 'action' => 'login', 'description' => 'User logged in', 'ip_address' => '127.0.0.1'],
            ['user_id' => 1, 'action' => 'upload', 'description' => 'Uploaded Project Plan', 'ip_address' => '127.0.0.1'],
        ]);
    }
}
