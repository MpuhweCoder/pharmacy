use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// ─── Customer Order Routes (auth required) ──────────────────────────────────
Route::prefix('orders')->name('orders.')->middleware('auth')->group(function () {

    // View order history
    Route::get('/',                    [OrderController::class, 'index'])->name('index');

    // Checkout page
    Route::get('/checkout',            [OrderController::class, 'checkout'])->name('checkout');

    // Place order (POST)
    Route::post('/checkout',           [OrderController::class, 'store'])->name('store');

    // Order confirmation page
    Route::get('/{order}/confirmation',[OrderController::class, 'confirmation'])->name('confirmation');

    // Order details
    Route::get('/{order}',             [OrderController::class, 'show'])->name('show');

    // Cancel order
    Route::patch('/{order}/cancel',    [OrderController::class, 'cancel'])->name('cancel');
});

// ─── Admin Order Routes ─────────────────────────────────────────────────────
Route::prefix('admin/orders')->name('admin.orders.')->middleware(['auth', 'role:admin,pharmacist'])->group(function () {

    // List all orders
    Route::get('/',                         [AdminOrderController::class, 'index'])->name('index');

    // View single order
    Route::get('/{order}',                  [AdminOrderController::class, 'show'])->name('show');

    // Update order status
    Route::patch('/{order}/status',         [AdminOrderController::class, 'updateStatus'])->name('status');
});