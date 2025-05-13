<?php

namespace App\Http\Controllers;

use App\Models\Socialmediamanager;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SocialmediamanagerController extends Controller
{
    public function index()
    {
        $managers = Socialmediamanager::all();
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
        $socialmedia->delete();
        return redirect()->route('socialmedia.index')->with('success', 'Manager deleted successfully.');
    }

    public function upload(Request $request, Socialmediamanager $manager)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $path = $request->file('file')->store('manager-documents', 'public');
        $fileUrl = '/storage/' . $path;

        // You can save the file URL to a related table or log it as needed.
        // Example: $manager->documents()->create(['file_path' => $fileUrl]);
        // For now, just return success.

        return back()->with('success', 'File uploaded successfully.');
    }
}
