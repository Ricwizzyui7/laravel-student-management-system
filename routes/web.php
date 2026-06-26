<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// 1. Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Dashboard (Breeze Default)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Authenticated Routes (Everything requiring a login goes inside here)
Route::middleware('auth')->group(function () {
    
    // User Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Your Custom Student Management Routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/dashboard', [StudentController::class, 'dashboard'])
        ->middleware(['auth'])
        ->name('dashboard');
});

// 4. Temporary Admin Creator Route
Route::get('/setup-admin-system', function () {
    // Check if the admin already exists so we don't duplicate it
    $adminExists = User::where('email', 'admin@gmail.com')->exists();
    
    if ($adminExists) {
        return "Admin account already exists on this server!";
    }

    // Create the admin user
    User::create([
        'name' => 'System Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('Wizzyui7'), // <-- Change this to your preferred password!
        'role' => 'admin', // <-- CRITICAL: Double-check your column name! Is it 'role', 'role_id', or 'is_admin'?
    ]);

    return "Admin user created successfully with admin privileges!";
});

// Load auth routes (This MUST stay at the very bottom)
require __DIR__.'/auth.php';