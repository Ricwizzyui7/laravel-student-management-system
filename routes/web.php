<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-everything-force', function () {
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('clear-compiled');
    return 'All Laravel caches have been hard-flushed successfully!';
});
// 1. Welcome Page (Automatically direct to the app)
Route::get('/', function () {
    return redirect('/dashboard');
});

// 2. Dashboard Route
Route::get('/dashboard', [StudentController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

// 3. Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // User Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 👥 STAFF & ADMIN ACCESS: View Student List
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');

    // 🧪 TEMPORARY DIAGNOSTIC: Commented out 'admin' middleware to check for 500 root cause
    // 🔐 ADMIN ONLY ACCESS (Now protected by our fixed, safe middleware)
    Route::middleware('admin')->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    });

    // 👥 Wildcard route at the bottom
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
});

// Load auth routes
require __DIR__.'/auth.php';