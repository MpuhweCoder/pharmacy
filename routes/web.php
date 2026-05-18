<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\PharmacistController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MedicineController;

// ─── Public Routes ─────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── Auth Routes ───────────────────────────────────────────────────────────

// Login
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// General Dashboard (redirects based on user role)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin() || $user->isPharmacist()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isCustomer()) {
            return redirect()->route('customer.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');
});

// ─── Admin Routes ───────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,pharmacist'])->group(function () {

    // Dashboard (already added in Feature 1)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ── Category Management ──────────────────────────────────────────────
    Route::resource('categories', CategoryController::class);

    // ── Medicine Management ──────────────────────────────────────────────
    Route::resource('medicines', MedicineController::class);

    // Quick stock update
    Route::patch('medicines/{medicine}/stock', [MedicineController::class, 'updateStock'])
         ->name('medicines.stock');

});

// ─── Pharmacist Routes (pharmacist & admin can access) ─────────────────────
Route::prefix('pharmacist')->name('pharmacist.')->middleware(['auth', 'role:pharmacist,admin'])->group(function () {
    Route::get('/dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
});

// ─── Customer Routes (all logged-in users) ─────────────────────────────────
Route::prefix('customer')->name('customer.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
});