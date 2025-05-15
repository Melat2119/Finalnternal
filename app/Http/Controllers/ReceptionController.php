<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ReceptionController extends Controller
{
    public function index()
    {
        $receptions = \App\Models\Reception::with(['documents' => function($q) {
            $q->select('documents.*');
        }])->get();

        return \Inertia\Inertia::render('Reception/Index', [
            'receptions' => $receptions
        ]);
    }

    public function create()
    {
        return Inertia::render('Reception/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:receptions,email',
        ]);
        Reception::create($validated);
        return redirect()->route('reception.index')->with('success', 'Reception created successfully.');
    }

    public function show(Reception $reception)
    {
        return Inertia::render('Reception/Show', [
            'reception' => $reception
        ]);
    }

    public function edit(Reception $reception)
    {
        return Inertia::render('Reception/Edit', [
            'reception' => $reception
        ]);
    }

    public function update(Request $request, Reception $reception)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:receptions,email,' . $reception->id,
        ]);
        $reception->update($validated);
        return redirect()->route('reception.index')->with('success', 'Reception updated successfully.');
    }

    public function destroy(Reception $reception)
    {
        $reception->delete();
        return redirect()->route('reception.index')->with('success', 'Reception deleted successfully.');
    }

    public function upload(Request $request, Reception $reception)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('documents', 'public');
        $fileUrl = '/storage/' . $path;

        $document = Document::create([
            'title' => $validated['title'],
            'type' => $validated['type'] ?? '',
            'file_path' => $fileUrl,
            'status' => 'pending',
            'uploaded_by' => Auth::user()->name ?? 'Reception',
        ]);

        $reception->documents()->attach($document->id);

        return back()->with('success', 'Document uploaded and linked to reception.');
    }
}
