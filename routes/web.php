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
use App\Http\Controllers\AdminController;

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

    // Add this route for file upload
    Route::post('/sales/{sale}/upload', [\App\Http\Controllers\SalesController::class, 'upload'])->name('sales.upload');

    // Remove or comment out this line:
    // Route::get('/reception', [\App\Http\Controllers\ReceptionController::class, 'index'])->middleware(['auth'])->name('reception');

    // Add this line for full CRUD:
    Route::resource('reception', \App\Http\Controllers\ReceptionController::class);

    // Remove or comment out this line:
    // Route::get('/socialmedia', [\App\Http\Controllers\SocialmediamanagerController::class, 'index'])->middleware(['auth'])->name('socialmedia');

    // Add this line for full CRUD:
    Route::resource('socialmedia', \App\Http\Controllers\SocialmediamanagerController::class);

    // Add this line for full CRUD for UI/UX Designers:
    Route::resource('ui', \App\Http\Controllers\UidesignerController::class);

    // Add a route for the manager documents page:
    Route::get('/manager/documents', [\App\Http\Controllers\ManagerController::class, 'documents'])->name('manager.documents');
    Route::get('/manager/letters', [\App\Http\Controllers\ManagerController::class, 'letters'])->name('manager.letters');
    Route::get('/manager/reports', [\App\Http\Controllers\ManagerController::class, 'reports'])->name('manager.reports');
    Route::get('/manager/approvals', [\App\Http\Controllers\ManagerController::class, 'approvals'])->name('manager.approvals');
    Route::post('/manager/approvals/{approval}/approve', [\App\Http\Controllers\ManagerController::class, 'approve'])->name('manager.approvals.approve');
    Route::post('/manager/approvals/{approval}/reject', [\App\Http\Controllers\ManagerController::class, 'reject'])->name('manager.approvals.reject');

    // Admin dashboard and operations
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/admin/documents', [AdminController::class, 'documents'])->name('admin.documents');
    Route::get('/admin/letters', [AdminController::class, 'letters'])->name('admin.letters');
    Route::get('/admin/auditlogs', [AdminController::class, 'auditlogs'])->name('admin.auditlogs');
    Route::get('/admin/manageusers', [AdminController::class, 'manageusers'])->name('admin.manageusers');

    // Add resource route for sales documents
    Route::resource('sales-documents', \App\Http\Controllers\SalesDocumentController::class);
});

// Inertia page routes for sections
require __DIR__.'/auth.php';
