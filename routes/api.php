<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LetterController;

// ...existing code...

Route::get('/admin/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index']);
Route::get('/admin/letter-stats', [LetterController::class, 'stats']);
Route::get('/admin/letters', [LetterController::class, 'index']);

// ...existing code...