<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\PharmacistController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MedicineController as AdminMedicineController;

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
    Route::resource('medicines', AdminMedicineController::class);

    // Quick stock update
    Route::patch('medicines/{medicine}/stock', [AdminMedicineController::class, 'updateStock'])
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

// ─── Order Routes (customers can view their orders) ───────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// ─── Prescription Routes (customers can manage prescriptions) ───────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
});
use App\Http\Controllers\CartController;

// ─── Cart Routes ────────────────────────────────────────────────────────────
// Cart is accessible to both guests and logged-in users
Route::prefix('cart')->name('cart.')->group(function () {

    // View cart page
    Route::get('/',             [CartController::class, 'index'])->name('index');

    // Add medicine to cart
    Route::post('/add',         [CartController::class, 'add'])->name('add');

    // Update item quantity
    Route::patch('/{cartItem}', [CartController::class, 'update'])->name('update');

    // Remove single item
    Route::delete('/{cartItem}',[CartController::class, 'remove'])->name('remove');

    // Clear entire cart
    Route::delete('/',          [CartController::class, 'clear'])->name('clear');

    // Get cart count (AJAX)
    Route::get('/count',        [CartController::class, 'count'])->name('count');
});
use App\Http\Controllers\MedicineController;

// ─── Profile Routes (authenticated users) ──────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::patch('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.update');
});

// Public medicine routes
Route::get('/medicines',          [MedicineController::class, 'index'])->name('medicines.index');
Route::get('/medicines/{medicine}',[MedicineController::class, 'show'])->name('medicines.show');

// ─── Help/Support Routes ───────────────────────────────────────────────────
Route::prefix('help')->name('help.')->group(function () {
    Route::get('/', [HelpController::class, 'index'])->name('index');
    Route::get('/contact', [HelpController::class, 'contact'])->name('contact');
    Route::post('/contact', [HelpController::class, 'submitContact'])->name('submit');
});