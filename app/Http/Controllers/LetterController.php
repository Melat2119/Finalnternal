<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    // Show the Inertia page for letters summary (main entry point)
    public function summary()
    {
        $letters = Letter::orderBy('created_at', 'desc')->take(10)->get();
        $users = \App\Models\User::select('id', 'name')->get();
        return inertia('Admin/LettersSummary', [
            'letters' => $letters,
            'users' => $users
        ]);
    }

    // CRUD operations: return Inertia redirect for Inertia frontend
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'created_by' => 'nullable|string|max:255',
        ]);
        Letter::create($validated);
        return redirect()->back()->with('success', 'Letter created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'created_by' => 'nullable|string|max:255',
        ]);
        $letter = Letter::findOrFail($id);
        $letter->update($validated);
        return redirect()->back()->with('success', 'Letter updated successfully.');
    }

    public function destroy($id)
    {
        $letter = Letter::findOrFail($id);
        $letter->delete();
        return redirect()->back()->with('success', 'Letter deleted successfully.');
    }

    // Return all letters as Inertia page for Inertia frontend
    public function index()
    {
        $letters = Letter::orderBy('created_at', 'desc')->take(10)->get();
        $users = \App\Models\User::select('id', 'name')->get();
        return inertia('Admin/LettersSummary', [
            'letters' => $letters,
            'users' => $users
        ]);
    }
}
