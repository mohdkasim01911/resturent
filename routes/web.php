<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PaymentController;
use Illuminate\Support\Facades\Log;

// ============= USER FRONTEND ROUTES =============
Route::prefix('/')->name('user.')->group(function () {
    // Public user routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
    Route::get('/food/{id}', [HomeController::class, 'foodDetail'])->name('food.detail');
    Route::get('/category/{id}', [HomeController::class, 'categoryWise'])->name('category.wise');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    
    // User authentication required routes
    Route::middleware(['auth'])->group(function () {
       
        
        
        Route::get('/user-dashboard', [HomeController::class, 'userDashboard'])->name('dashboard');

        // Cart routes
    //    Route::prefix('cart')->group(function () {
    //        Route::get('/', [CartController::class, 'index'])->name('cart');
    //        Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    //        Route::patch('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    //        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    //        Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
    //    });
        
        // Checkout routes
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        
        // User orders
        Route::get('/my-orders', [UserOrderController::class, 'index'])->name('orders');
        Route::get('/order/{id}', [UserOrderController::class, 'show'])->name('order.show');
        Route::post('/order/{id}/cancel', [UserOrderController::class, 'cancel'])->name('order.cancel');

    
        // Payment Routes - YEH ADD KAREIN
        Route::get('/payment/{order_id}', [PaymentController::class, 'index'])->name('payment.index');
        Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
        

    });
});




// ============= ADMIN PANEL ROUTES =============
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Food Management
    Route::resource('foods', FoodController::class);
    Route::post('/foods/{id}/toggle-status', [FoodController::class, 'toggleStatus'])->name('foods.toggle-status');
    
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // // Order Management
    // Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    // Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    // Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    // Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

      // Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/{id}/invoice', [AdminOrderController::class, 'generateInvoice'])->name('orders.invoice');
    Route::get('/orders/export/csv', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::post('/orders/bulk-update', [OrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-update');

});

// Get food variants (AJAX)
Route::get('/get-food-variants/{id}', function($id) {
    $food = App\Models\Food::findOrFail($id);
    return response()->json([
        'id' => $food->id,
        'name' => $food->name,
        'variants' => $food->variants
    ]);
})->name('get.food.variants');

Route::prefix('/')->name('user.')->group(function () {
    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('cart.update'); // Changed from patch to post
        Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // Changed from delete to post
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear'); // Changed from delete to post
    });
});

Route::get('/cart/count', function() {
    return response()->json(['count' => count(session('cart', []))]);
})->name('cart.count');

// Profile routes (common for both)
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
