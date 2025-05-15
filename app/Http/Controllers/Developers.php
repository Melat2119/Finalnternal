<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class Developers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developers = Developer::with(['documents' => function($q) {
            $q->select('documents.*');
        }])->get();

        foreach ($developers as $developer) {
            foreach ($developer->documents as $doc) {
                $doc->developer_id = $developer->id;
            }
        }

        return Inertia::render('Developers/Index', [
            'developers' => $developers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show form to create developer
        return Inertia::render('Developers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store developer
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:developers,email',
        ]);
        Developer::create($validated);
        return redirect()->route('developers.index')->with('success', 'Developer created successfully.');
    }

    /**
     * Store a newly created document for a developer.
     */
    public function storeDocument(Request $request, Developer $developer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('documents', 'public');
        $fileUrl = '/storage/' . $path;

        $document = Document::create([
            'title' => $validated['title'],
            'department' => $validated['department'] ?? '',
            'type' => $validated['type'] ?? '',
            'file_path' => $fileUrl,
            'uploaded_by' => Auth::check() ? (Auth::user()->name ?? Auth::user()->email) : ($developer->name ?? ''),
            'status' => 'pending',
            'approval_comment' => 'Pending review', // Set a default value
            'approved_by' => Auth::check() ? (Auth::user()->name ?? Auth::user()->email) : 'System', // Set to current user or 'System'
        ]);

        $developer->documents()->attach($document->id);

        return redirect()->back()->with('success', 'Document uploaded and linked to developer.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        // Show a single developer
        return Inertia::render('Developers/Show', [
            'developer' => $developer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Developer $developer)
    {
        // Show form to edit developer
        return Inertia::render('Developers/Edit', [
            'developer' => $developer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        // Validate and update developer
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:developers,email,' . $developer->id,
        ]);
        $developer->update($validated);
        return redirect()->route('developers.index')->with('success', 'Developer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        // Delete developer
        $developer->delete();
        return redirect()->route('developers.index')->with('success', 'Developer deleted successfully.');
    }
}
