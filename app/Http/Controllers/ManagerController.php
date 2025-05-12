<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Document;

class ManagerController extends Controller
{
    public function documents()
    {
        $documents = Document::all();
        return Inertia::render('Manager/Document', [
            'documents' => $documents
        ]);
    }

    public function letters()
    {
        $letters = \App\Models\Letter::all();
        return \Inertia\Inertia::render('Manager/Letters', [
            'letters' => $letters
        ]);
    }

    public function reports()
    {
        // Fetch or calculate report data as needed
        return \Inertia\Inertia::render('Manager/Reports', [
            // 'reports' => $reports
        ]);
    }

    public function approvals()
    {
        // Example: Fetch approval requests (customize as needed)
        $approvals = \App\Models\Approval::with(['document', 'requestedBy'])->get();
        return \Inertia\Inertia::render('Manager/Approvals', [
            'approvals' => $approvals
        ]);
    }

    public function approve(\App\Models\Approval $approval)
    {
        $approval->update(['status' => 'approved']);
        return redirect()->route('manager.approvals');
    }

    public function reject(\App\Models\Approval $approval)
    {
        $approval->update(['status' => 'rejected']);
        return redirect()->route('manager.approvals');
    }
}
