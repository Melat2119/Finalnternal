<?php

namespace App\Http\Controllers;

use App\Models\Uidesigner;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class UidesignerController extends Controller
{
    public function index()
    {
        $designers = Uidesigner::with(['documents' => function($q) {
            $q->select('documents.*');
        }])->get();

        foreach ($designers as $designer) {
            foreach ($designer->documents as $doc) {
                $doc->uidesigner_id = $designer->id;
            }
        }

        return Inertia::render('ux designer/Index', [
            'designers' => $designers,
        ]);
    }

    public function create()
    {
        return Inertia::render('ux designer/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:uidesigners,email',
        ]);
        Uidesigner::create($validated);
        return redirect()->route('ui.index')->with('success', 'Designer created successfully.');
    }

    public function show(Uidesigner $ui)
    {
        return Inertia::render('ux designer/Show', [
            'designer' => $ui
        ]);
    }

    public function edit(Uidesigner $ui)
    {
        return Inertia::render('ux designer/Edit', [
            'designer' => $ui
        ]);
    }

    public function update(Request $request, Uidesigner $ui)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:uidesigners,email,' . $ui->id,
        ]);
        $ui->update($validated);
        return redirect()->route('ui.index')->with('success', 'Designer updated successfully.');
    }

    public function destroy(Uidesigner $ui)
    {
        $ui->delete();
        return redirect()->route('ui.index')->with('success', 'Designer deleted successfully.');
    }

    public function storeDocument(Request $request, Uidesigner $uidesigner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('documents', 'public');
        $fileUrl = '/storage/' . $path;

        Document::create([
            'title' => $validated['title'],
            'department' => $validated['department'] ?? '',
            'type' => $validated['type'] ?? '',
            'file_path' => $fileUrl,
            'uidesigner_id' => $uidesigner->id,
            'status' => 'pending',
            'approval_comment' => 'Pending review',
            'approved_by' => Auth::check() ? (Auth::user()->name ?? Auth::user()->email) : 'System',
        ]);

        return redirect()->back()->with('success', 'Document uploaded and linked to designer.');
    }
}
