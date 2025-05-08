<?php

namespace App\Http\Controllers;

use App\Models\Socialmediamanager;
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
}
