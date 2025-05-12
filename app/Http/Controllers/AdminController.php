<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Example stats, adjust as needed for your models
        $totalDocuments = Document::count();
        $users = User::count();
        
        // Remove or comment out this line if your documents table does not have a 'status' column:
        // $pendingApprovals = Document::where('status', 'pending')->count();

        // Use this instead if you don't have a 'status' column:
        $pendingApprovals = 0; // Or use another logic/column if available

        // Example: Recent activity (customize as needed)
        $recentActivity = [
            'User "Manager1" uploaded \'Budget_Report.xlsx\'',
            'Director approved letter \'Partnership Agreement\'',
            'Unauthorized access attempt detected',
        ];

        // Remove or comment out this line if 'department' column does not exist:
        // $documentsByDepartment = Document::selectRaw('department, count(*) as count')
        //     ->groupBy('department')
        //     ->pluck('count', 'department');

        // Use an empty array or another logic if you want:
        $documentsByDepartment = [];

        return Inertia::render('Admin/Index', [
            'stats' => [
                'totalDocuments' => $totalDocuments,
                'users' => $users,
                'pendingApprovals' => $pendingApprovals,
            ],
            'recentActivity' => $recentActivity,
            'documentsByDepartment' => $documentsByDepartment,
        ]);
    }

    public function users()
    {
        $users = \App\Models\User::all();
        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    public function settings()
    {
        return Inertia::render('Admin/Settings');
    }

    public function documents()
    {
        $documents = \App\Models\Document::all();
        return Inertia::render('Admin/DocumentOverview', [
            'documents' => $documents
        ]);
    }

    public function letters()
    {
        $letters = \App\Models\Letter::all();
        return Inertia::render('Admin/LettersSummary', [
            'letters' => $letters
        ]);
    }

    public function auditlogs()
    {
        $logs = \App\Models\AuditLog::orderByDesc('created_at')->get();
        return Inertia::render('Admin/AuditLogs', [
            'logs' => $logs
        ]);
    }

    public function manageusers()
    {
        $users = \App\Models\User::all();
        return Inertia::render('Admin/ManageUsers', [
            'users' => $users
        ]);
    }
}
