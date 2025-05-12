<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        // Fetch latest 100 logs for the admin page, ordered by timestamp
        $logs = AuditLog::orderByDesc('timestamp')->limit(100)->get();

        // Format for frontend
        return $logs->map(function ($log) {
            return [
                'id' => $log->id,
                'user' => $log->user,
                'action' => $log->action,
                'description' => $log->description,
                'timestamp' => $log->timestamp,
            ];
        });
    }
}
