<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Developers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return all developers to Vue via Inertia
        $developers = Developer::all();
        return Inertia::render('Developers/Developers', [
            'developers' => $developers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show form to create developer
        return view('developers.create');
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
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        // Show a single developer
        return view('developers.show', compact('developer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Developer $developer)
    {
        // Show form to edit developer
        return view('developers.edit', compact('developer'));
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
