<?php

use Illuminate\Support\Facades\Route;

// ...existing code...

Route::get('/admin/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index']);

// ...existing code...