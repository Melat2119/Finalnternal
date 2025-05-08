<?php

namespace App\Http\Controllers;

use App\Models\Uidesigner;
use Inertia\Inertia;

class UidesignerController extends Controller
{
    public function index()
    {
        $designers = Uidesigner::all();
        return Inertia::render('ux designer/Index', [
            'designers' => $designers,
        ]);
    }
}
