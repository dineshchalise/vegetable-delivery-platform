<?php

use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\HubController as AdminHubController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\CustomerOrderController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('products', [CatalogController::class, 'products']);
Route::get('categories', [CatalogController::class, 'categories']);
Route::get('hubs', [CatalogController::class, 'hubs']);
Route::post('orders', [CustomerOrderController::class, 'store'])->middleware('throttle:60,1');

Route::post('auth/send-otp', [AuthController::class, 'sendOtp'])->middleware('throttle:otp');
Route::post('auth/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:60,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/user', [AuthController::class, 'user']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('orders', [CustomerOrderController::class, 'index']);
    Route::get('orders/{order}', [CustomerOrderController::class, 'show']);
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
});

Route::prefix('admin')->middleware(['auth:sanctum', 'staff'])->group(function () {
    Route::get('dashboard/stats', DashboardController::class);
    Route::apiResource('products', AdminProductController::class);
    Route::post('products/bulk-price', [AdminProductController::class, 'bulkPrice']);
    Route::post('products/bulk-publish', [AdminProductController::class, 'bulkPublish']);
    Route::apiResource('categories', AdminCategoryController::class);
    Route::post('categories/reorder', [AdminCategoryController::class, 'reorder']);
    Route::apiResource('hubs', AdminHubController::class);
    Route::get('orders', [AdminOrderController::class, 'index']);
    Route::get('orders/{order}', [AdminOrderController::class, 'show']);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus']);
    Route::get('customers', [AdminCustomerController::class, 'index']);
    Route::patch('customers/{customer}/block', [AdminCustomerController::class, 'block']);
});
