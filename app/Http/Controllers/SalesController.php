<?php

namespace App\Http\Controllers;

use App\Models\SalesDocument;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    public function index()
    {
        $sales = SalesDocument::all();
        Log::info('SalesController@index - sales:', $sales->toArray()); // Debug: log sales data
        return Inertia::render('Sales/Index', [
            'sales' => $sales
        ]);
    }

    public function create()
    {
        return Inertia::render('Sales/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sales,email',
        ]);
        SalesDocument::create($validated);
        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

    public function show(SalesDocument $sale)
    {
        return Inertia::render('Sales/Show', [
            'sale' => $sale
        ]);
    }

    public function edit(SalesDocument $sale)
    {
        return Inertia::render('Sales/Edit', [
            'sale' => $sale
        ]);
    }

    public function update(Request $request, SalesDocument $sale)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'salesperson' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'validity_period' => 'nullable|date',
        ]);
        $sale->update($validated);
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy(SalesDocument $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }

    public function upload(Request $request, SalesDocument $sale)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $path = $request->file('file')->store('sales_documents', 'public');
        $fileUrl = Storage::url($path);

        $sale->file_url = $fileUrl;
        $sale->save();

        return back()->with('success', 'File uploaded successfully.');
    }
}
