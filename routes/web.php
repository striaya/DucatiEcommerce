<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {   
    return redirect('/products');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/payments/webhook', [PaymentController::class, 'webhook']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::get('/profile/addresses', [UserController::class, 'addresses']);
    Route::post('/profile/addresses', [UserController::class, 'storeAddress']);
    Route::delete('/profile/addresses', [UserController::class, 'destroyAddress']);

    Route::get('/cart', [UserController::class, 'index'])->name('cart.index');
    Route::post('/cart', [UserController::class, 'store']);
    Route::put('/cart/{cartId}', [UserController::class, 'update']);
    Route::delete('/cart/{cartId}', [UserController::class, 'destroy']);
    Route::delete('/cart', [UserController::class, 'clear']);

    Route::get('/checkout', [UserController::class, 'checkout']);
    Route::put('/orders', [UserController::class, 'store']);
    Route::get('/orders', [UserController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}', [UserController::class, 'show']);

    Route::get('/orders/{orderId}/payment', [PaymentController::class, 'show']);
    Route::post('/orders/{orderId}/payment', [PaymentController::class, 'store']);
    Route::get('/payments/{id}', [PaymentController::class, 'detail']);
    Route::post('/payments/{id}/confirm', [PaymentController::class, 'confirm']);

    Route::get('/orders/{orderId}/credit', [CreditController::class, 'create']);
    Route::post('/orders/{orderId}/credit', [CreditController::class, 'store']);
    Route::get('/credits', [CreditController::class, 'index']);
    Route::get('/credits/{id}', [CreditController::class, 'show']);
    Route::post('/credits/{creditId}/schedules/{scheduleId}/pay', [CreditController::class, 'payInstallment']);

    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/', fn() => redirect('/admin/orders'));

    Route::get('/users', [UserController::class, 'adminIndex']);
    Route::patch('/users/{id}/kyc', [UserController::class, 'updateKyc']);

    Route::get('/products', [ProductController::class, 'adminIndex']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'adminIndex']);
    Route::get('/orders/{id}', [OrderController::class, 'adminShow']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

    Route::get('/credits', [CreditController::class, 'adminIndex']);
    Route::get('/credits/{id}', [CreditController::class, 'adminShow']);
    Route::put('/credits/{id}/status', [CreditController::class, 'updateStatus']);
});