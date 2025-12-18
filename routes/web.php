<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\DownloadController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CustomDesignController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// File serving routes
Route::get('/files/preview/{path}', [FileController::class, 'previewImage'])->name('files.preview');
Route::get('/files/payment/{orderId}/{path}', [FileController::class, 'paymentProof'])->name('files.payment');

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Health check endpoint for Railway
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Checkout
    Route::get('/checkout/{product}', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout/{product}', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('throttle:10,1');

    // Orders
    Route::middleware(['user'])->prefix('user')->name('user.')->group(function () {
        // Profile
        Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        
        // Orders
        Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/upload-payment', [UserOrderController::class, 'uploadPaymentProof'])->name('orders.upload-payment')->middleware('throttle:5,1');
        
        // Custom Design - Upload Revision
        Route::post('/orders/{order}/upload-revision', [CustomDesignController::class, 'uploadRevision'])->name('orders.upload-revision');

        // Download
        Route::get('/download/{order}/{token}', [DownloadController::class, 'download'])->name('download')->middleware('throttle:20,1');
        
        // Custom Design - Download Design File
        Route::get('/orders/{order}/download-design/{file}', [CustomDesignController::class, 'downloadDesign'])->name('orders.download-design');
    });
    
    // Chat Routes (accessible by both admin and user)
    Route::get('/orders/{order}/chat', [ChatController::class, 'index'])->name('orders.chat');
    Route::post('/orders/{order}/chat/send', [ChatController::class, 'sendMessage'])->name('orders.chat.send')->middleware('throttle:30,1');
    Route::get('/orders/{order}/chat/messages', [ChatController::class, 'getMessages'])->name('orders.chat.messages');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/verify', [AdminOrderController::class, 'verifyPayment'])->name('orders.verify');
    Route::post('/orders/{order}/reject', [AdminOrderController::class, 'rejectPayment'])->name('orders.reject');
    
    // Custom Design Orders
    Route::post('/orders/{order}/approve', [AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{order}/mark-in-progress', [AdminOrderController::class, 'markInProgress'])->name('orders.mark-in-progress');
    Route::post('/orders/{order}/mark-completed', [AdminOrderController::class, 'markCompleted'])->name('orders.mark-completed');
    Route::post('/orders/{order}/upload-design', [CustomDesignController::class, 'uploadDesign'])->name('orders.upload-design');
    Route::get('/orders/{order}/download-design/{file}', [CustomDesignController::class, 'downloadDesignFile'])->name('orders.download-design-file');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}/customize', [CategoryController::class, 'customize'])->name('categories.customize');
    Route::put('/categories/{category}/customize', [CategoryController::class, 'updateCustomization'])->name('categories.updateCustomization');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
