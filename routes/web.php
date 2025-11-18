<?php

use App\Models\Barangay;
use App\Models\Province;
use App\Models\CitiesMunicipalities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Admin\RulesController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\TrafficRulesController;
use App\Http\Controllers\Admin\BarangayController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\ViolationController;
use App\Http\Controllers\OfficerRegisterController;
use App\Http\Controllers\ReportAttachmentController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Officer\OfficerDashboardController;
use App\Http\Controllers\Officer\ViolationController as OfficerViolationController;

Route::get('/test-env', function () {
    dd(env('IPROG_API_TOKEN'));
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/get-cities/{provinceId}', [RegisteredUserController::class, 'getCities']);

Route::post('/notifications/mark-as-read', function () {
    $user = Auth::user();
    $user->unreadNotifications->markAsRead();
    return back();
})->name('notifications.read');

Route::get('/traffic-rules', [TrafficRulesController::class, 'index'])->name('traffic.rules');

Route::get('/provinces/{region}', function ($regionId) {
    return Province::where('region_id', $regionId)->get();
});

Route::get('/cities/{province}', function ($provinceId) {
    return CitiesMunicipalities::where('province_id', $provinceId)->get();
});

Route::get('/barangays/{city}', function ($cityId) {
    return Barangay::where('city_municipality_id', $cityId)->get();
});

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

Route::get('officer/register', [OfficerRegisterController::class, 'create'])->name('officer.register');
Route::post('officer/register', [OfficerRegisterController::class, 'store'])->name('officer.register.store');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/invitations', [InvitationController::class, 'index'])->name('invitations.index');

    Route::resource('categories', CategoryController::class);
    Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');

    Route::resource('violations', ViolationController::class);
    Route::patch('violations/{id}/restore', [ViolationController::class, 'restore'])->name('violations.restore');

    Route::resource('users', UserController::class);
    Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    Route::resource('rules', RulesController::class);
    Route::patch('rules/{id}/restore', [RulesController::class, 'restore'])->name('rules.restore');

    Route::resource('regions', RegionController::class);
    Route::patch('regions/{id}/restore', [RegionController::class, 'restore'])->name('regions.restore');

    Route::resource('provinces', ProvinceController::class);
    Route::patch('provinces/{id}/restore', [ProvinceController::class, 'restore'])->name('provinces.restore');

    Route::resource('cities', CityController::class);
    Route::patch('cities/{id}/restore', [CityController::class, 'restore'])->name('cities.restore');

    Route::resource('barangays', BarangayController::class);
    Route::patch('barangays/{id}/restore', [BarangayController::class, 'restore'])->name('barangays.restore');
});

// Officer routes
Route::prefix('officer')->name('officer.')->middleware(['auth', 'verified', 'ensure.phone', 'role:officer'])->group(function () {
    Route::get('/dashboard', [OfficerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/start-duty', [OfficerDashboardController::class, 'startDuty'])->name('startDuty');
    Route::post('/dashboard/end-duty', [OfficerDashboardController::class, 'endDuty'])->name('endDuty');
    Route::post('/dashboard/heartbeat', [OfficerDashboardController::class, 'heartbeat'])->name('heartbeat');
    Route::resource('violations', OfficerViolationController::class);
    Route::post('/violations/{id}/restore', [OfficerViolationController::class, 'restore'])->name('violations.restore');
    Route::post('/violations/status/{id}', [OfficerViolationController::class, 'status'])->name('violations.status');

    Route::post('/users/{user}/ban', [OfficerDashboardController::class, 'ban'])->name('users.ban');
    Route::post('/users/{user}/unban', [OfficerDashboardController::class, 'unban'])->name('users.unban');
});

// Reporter routes
Route::middleware(['auth', 'verified', 'role:reporter'])->group(function () {
    // Route::get('/reporter/dashboard', function () {
    //     return view('dashboard.reporter');
    // })->name('reporter.dashboard');

    Route::get('/reporter/dashboard', [ReportController::class, 'dashboard'])->name('reporter.dashboard');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/store', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/edit/{id}', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/edit/{id}', [ReportController::class, 'update'])->name('reports.update');
    Route::get('/reports/show/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::delete('/reports/destroy/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
});

Route::delete('/attachments/{id}', [ReportAttachmentController::class, 'destroyAttachment'])->name('attachments.destroy');

require __DIR__.'/auth.php';
