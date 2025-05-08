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
    Route::resource('feedback', FeedbackController::class)->except(['show']);

    // Replace this:
    // Route::get('/developers', function () {
    //     return Inertia::render('Developers/Developers');
    // })->middleware(['auth'])->name('developers');

    // With this:
    Route::get('/developers', [\App\Http\Controllers\Developers::class, 'index'])->name('developers');

    // Replace this:
    // Route::get('/sales', function () {
    //     return Inertia::render('Sales/index');
    // })->middleware(['auth'])->name('sales');

    // With this:
    Route::get('/sales', [\App\Http\Controllers\SalesController::class, 'index'])->name('sales');
});

// Inertia page routes for sections
Route::get('/reception', [\App\Http\Controllers\ReceptionController::class, 'index'])->middleware(['auth'])->name('reception');

Route::get('/ui', [\App\Http\Controllers\UidesignerController::class, 'index'])->middleware(['auth'])->name('ui');

Route::get('/socialmedia', [\App\Http\Controllers\SocialmediamanagerController::class, 'index'])->middleware(['auth'])->name('socialmedia');

require __DIR__.'/auth.php';
