<?php

use App\Models\Barangay;
use App\Models\Province;
use App\Models\CitiesMunicipalities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/provinces/{region}', fn($id) => Province::where('region_id', $id)->orderBy('province_name')->get(['id', 'province_name']));
Route::get('/cities/{province}', fn($id) => CitiesMunicipalities::where('province_id', $id)->orderBy('city_name')->get(['id', 'city_name']));
Route::get('/barangays/{city}', fn($id) => Barangay::where('city_municipality_id', $id)->orderBy('brgy_name')->get(['id', 'brgy_name']));

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'officer' => redirect()->route('officer.dashboard'),
        'reporter' => redirect()->route('reporter.dashboard'),
        default => abort(403, 'Unauthorized')
    };
})->middleware(['auth'])->name('dashboard');

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

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/show', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/store', [ReportController::class, 'store'])->name('reports.store');
    Route::post('/reports/destroy', [ReportController::class, 'destroy'])->name('reports.destroy');
});

require __DIR__.'/auth.php';
