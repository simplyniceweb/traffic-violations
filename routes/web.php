<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');
});

// Officer routes
Route::middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/officer/dashboard', function () {
        return view('dashboard.officer');
    })->name('officer.dashboard');
});

// Reporter routes
Route::middleware(['auth', 'role:reporter'])->group(function () {
    Route::get('/reporter/dashboard', function () {
        return view('dashboard.reporter');
    })->name('reporter.dashboard');
});

require __DIR__.'/auth.php';
