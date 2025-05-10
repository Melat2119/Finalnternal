<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    return Inertia::render('Admin/Index');
})->middleware(['auth'])->name('admin');

Route::get('/manager', function () {
    return Inertia::render('Manager/Index');
})->middleware(['auth'])->name('manager');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resourceful routes for main entities
    Route::resource('documents', DocumentController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('feedback', FeedbackController::class);

    // Use only the resourceful route:
    Route::resource('developers', \App\Http\Controllers\Developers::class);

    // Remove or comment out this line:
    // Route::get('/sales', [\App\Http\Controllers\SalesController::class, 'index'])->name('sales');

    // Add this line for full CRUD:
    Route::resource('sales', \App\Http\Controllers\SalesController::class);

    // Remove or comment out this line:
    // Route::get('/reception', [\App\Http\Controllers\ReceptionController::class, 'index'])->middleware(['auth'])->name('reception');

    // Add this line for full CRUD:
    Route::resource('reception', \App\Http\Controllers\ReceptionController::class);

    // Only admin and manager can access Social Media Manager pages
    Route::resource('socialmedia', \App\Http\Controllers\SocialmediamanagerController::class)
        ->middleware('role:admin|manager');

    // Add this line for full CRUD for UI/UX Designers:
    Route::resource('ui', \App\Http\Controllers\UidesignerController::class);
});

// Inertia page routes for sections
require __DIR__.'/auth.php';
