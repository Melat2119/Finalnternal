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

    // Add other CRUD methods as needed...
}
