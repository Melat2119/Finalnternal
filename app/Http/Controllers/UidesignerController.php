<?php

namespace App\Http\Controllers;

use App\Models\Uidesigner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UidesignerController extends Controller
{
    public function index()
    {
        $designers = Uidesigner::all();
        return Inertia::render('ux designer/Index', [
            'designers' => $designers
        ]);
    }

    public function create()
    {
        return Inertia::render('ux designer/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:uidesigners,email',
        ]);
        Uidesigner::create($validated);
        return redirect()->route('ui.index')->with('success', 'Designer created successfully.');
    }

    public function show(Uidesigner $ui)
    {
        return Inertia::render('ux designer/Show', [
            'designer' => $ui
        ]);
    }

    public function edit(Uidesigner $ui)
    {
        return Inertia::render('ux designer/Edit', [
            'designer' => $ui
        ]);
    }

    public function update(Request $request, Uidesigner $ui)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:uidesigners,email,' . $ui->id,
        ]);
        $ui->update($validated);
        return redirect()->route('ui.index')->with('success', 'Designer updated successfully.');
    }

    public function destroy(Uidesigner $ui)
    {
        $ui->delete();
        return redirect()->route('ui.index')->with('success', 'Designer deleted successfully.');
    }
}
