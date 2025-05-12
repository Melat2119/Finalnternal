<?php

namespace App\Http\Controllers;

use App\Models\SalesDocument;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesDocumentController extends Controller
{
    public function index()
    {
        $documents = SalesDocument::all();
        return Inertia::render('SalesDocuments/Index', [
            'documents' => $documents
        ]);
    }

    public function create()
    {
        return Inertia::render('SalesDocuments/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'salesperson' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'validity_period' => 'nullable|date',
        ]);
        SalesDocument::create($validated);
        return redirect()->route('sales-documents.index')->with('success', 'Sales document created successfully.');
    }

    public function show(SalesDocument $salesDocument)
    {
        return Inertia::render('SalesDocuments/Show', [
            'document' => $salesDocument
        ]);
    }

    public function edit(SalesDocument $salesDocument)
    {
        return Inertia::render('SalesDocuments/Edit', [
            'document' => $salesDocument
        ]);
    }

    public function update(Request $request, SalesDocument $salesDocument)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'salesperson' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'validity_period' => 'nullable|date',
        ]);
        $salesDocument->update($validated);
        return redirect()->route('sales-documents.index')->with('success', 'Sales document updated successfully.');
    }

    public function destroy(SalesDocument $salesDocument)
    {
        $salesDocument->delete();
        return redirect()->route('sales-documents.index')->with('success', 'Sales document deleted successfully.');
    }
}
