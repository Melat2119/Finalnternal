<?php

namespace App\Http\Controllers;

use App\Models\Uidesigner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UidesignerController extends Controller
{
    public function index()
    {
        // Fetch all UI designers from the database
        $designers = Uidesigner::all();
        // Pass as 'designers' to match prop in Vue
        return Inertia::render('ux designer/Index', [
            'designers' => $designers
        ]);
    }

    // Add other CRUD methods as needed...
}
