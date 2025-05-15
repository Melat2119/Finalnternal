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
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        // Store file in local storage (storage/app/public)
        $path = $request->file('file')->store('documents', 'public');
        $fileUrl = '/storage/' . $path; // This will be accessible via the public URL

        $document = \App\Models\Document::create([
            'title' => $validated['title'],
            'department' => $validated['department'] ?? null,
            'file_path' => $fileUrl,
            // ...other fields as needed...
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
        $document = \App\Models\Document::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'uploaded_by' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'approval_comment' => 'nullable|string|max:255',
            'approved_by' => 'nullable|string|max:255',
        ]);
        $document->update($validated);
        return back()->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Download the specified resource.
     */
    public function download($id)
    {
        $document = \App\Models\Document::findOrFail($id);
        // Remove leading slash if present
        $relativePath = ltrim($document->file_path, '/');
        // Remove 'storage/' prefix to get the path relative to storage/app/public
        $relativePath = preg_replace('#^storage/#', '', $relativePath);

        if (!Storage::disk('public')->exists($relativePath)) {
            abort(404, 'File not found.');
        }

        return response()->download(storage_path('app/public/' . $relativePath), basename($relativePath));
    }
}
