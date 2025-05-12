<?php

namespace App\Http\Controllers;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $document = Document::all();
        return Inertia::render('Documents/Index',[
            'documents'=>$document,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'uploaded_by' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        // Store file and get URL
        $path = $request->file('file')->store('documents', 'public');
        $fileUrl = Storage::url($path);

        $document = \App\Models\Document::create([
            'title' => $validated['title'],
            'department' => $validated['department'] ?? null,
            'uploaded_by' => $validated['uploaded_by'] ?? null,
            'status' => $validated['status'] ?? 'pending',
            'file_url' => $fileUrl,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
