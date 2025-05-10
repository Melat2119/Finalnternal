<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReceptionController extends Controller
{
    public function index()
    {
        $receptions = Reception::all();
        return Inertia::render('Reception/Index', [
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
}
