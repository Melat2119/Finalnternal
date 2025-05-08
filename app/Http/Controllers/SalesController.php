<?php

namespace App\Http\Controllers;

use App\Models\Sale; // changed from Sales to Sale
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::all(); // changed from Sales::all() to Sale::all()
        return Inertia::render('Sales/Index', [
            'sales' => $sales
        ]);
    }

    // Add other CRUD methods as needed...
}
