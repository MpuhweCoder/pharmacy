<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\PharmacistController;
use App\Http\Controllers\Auth\CustomerController;

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

// ─── Admin Routes (only admin can access) ──────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard',        [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',            [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
});

// ─── Pharmacist Routes (pharmacist & admin can access) ─────────────────────
Route::prefix('pharmacist')->name('pharmacist.')->middleware(['auth', 'role:pharmacist,admin'])->group(function () {
    Route::get('/dashboard', [PharmacistController::class, 'dashboard'])->name('dashboard');
});

// ─── Customer Routes (all logged-in users) ─────────────────────────────────
Route::prefix('customer')->name('customer.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
});