<?php

namespace App\Http\Controllers;

use App\Models\Socialmediamanager;
use App\Models\Document; // Import Document model
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class SocialmediamanagerController extends Controller
{
    public function index()
    {
        $managers = Socialmediamanager::with(['documents' => function($q) {
            // Ensure all necessary document fields are selected
            $q->select('documents.*'); // Or specify columns if needed
        }])->get();

        return Inertia::render('Socialmediamanager/Index', [
            'managers' => $managers
        ]);
    }

    public function create()
    {
        return Inertia::render('Socialmediamanager/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:socialmediamanagers,email',
        ]);
        Socialmediamanager::create($validated);
        return redirect()->route('socialmedia.index')->with('success', 'Manager created successfully.');
    }

    public function show(Socialmediamanager $socialmedia)
    {
        // Eager load documents for the single manager view if needed
        $socialmedia->load(['documents' => function($q){
            $q->select('documents.*');
        }]);
        return Inertia::render('Socialmediamanager/Show', [
            'manager' => $socialmedia
        ]);
    }

    public function edit(Socialmediamanager $socialmedia)
    {
        return Inertia::render('Socialmediamanager/Edit', [
            'manager' => $socialmedia
        ]);
    }

    public function update(Request $request, Socialmediamanager $socialmedia)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:socialmediamanagers,email,' . $socialmedia->id,
        ]);
        $socialmedia->update($validated);
        return redirect()->route('socialmedia.index')->with('success', 'Manager updated successfully.');
    }

    public function destroy(Socialmediamanager $socialmedia)
    {
        // Detach all related documents before deleting the manager to maintain pivot table integrity if needed,
        // or rely on onDelete('cascade') on the foreign keys in the pivot table migration.
        // $socialmedia->documents()->detach(); 
        $socialmedia->delete();
        return redirect()->route('socialmedia.index')->with('success', 'Manager deleted successfully.');
    }

    public function upload(Request $request, Socialmediamanager $manager)
    {
        $validated = $request->validate([
            // doc_id is passed from the frontend if uploading to an existing document placeholder
            // if it's a new document for the manager, this might not be present.
            'doc_id' => 'sometimes|nullable|exists:documents,id',
            'title' => 'required_without:doc_id|string|max:255', // Title required if not updating existing doc
            'type' => 'nullable|string|max:255',
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $path = $request->file('file')->store('documents', 'public');
        $fileUrl = '/storage/' . $path;

        if ($request->filled('doc_id')) {
            // This case is if you intend to update an existing document's file
            // and ensure it's linked. The current UI seems to imply creating new docs per manager.
            // For simplicity, let's assume we always create a new document record
            // and link it. If you need to replace a file for an *existing* document,
            // that logic would be different (fetch doc, update file_path, ensure link).
            // The current UI `triggerFileInput(doc, manager)` passes a `doc`,
            // which implies updating. Let's adjust to create a new doc and link it.
            // Or, if the intention is to replace the file of `doc_id`:
            // $document = Document::find($validated['doc_id']);
            // $document->file_path = $fileUrl;
            // // Potentially update other fields like title, type if provided
            // if ($request->has('title')) $document->title = $request->title;
            // if ($request->has('type')) $document->type = $request->type;
            // $document->save();
        } else {
            // Create a new document
            $document = Document::create([
                'title' => $validated['title'],
                'type' => $validated['type'] ?? '',
                'file_path' => $fileUrl,
                'status' => 'pending', // Default status
                'uploaded_by' => Auth::user()->name, // Or other logic for uploaded_by
                // Add other necessary default fields for a document
            ]);
        }
        
        // Attach the document to the manager via the pivot table
        // Use syncWithoutDetaching to avoid duplicate entries if the link already exists
        $manager->documents()->syncWithoutDetaching([$document->id]);

        return back()->with('success', 'Document uploaded and linked to manager.');
    }
}
