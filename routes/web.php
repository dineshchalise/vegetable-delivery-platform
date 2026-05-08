<?php

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\CustomerManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\HubManager;
use App\Livewire\Admin\OrderManager;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Admin\SettingsForm;
use App\Livewire\Admin\StaffManager;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\LoginPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\OrderTrackingPage;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/checkout', CheckoutPage::class)->name('checkout');
Route::get('/login', LoginPage::class)->name('login');
Route::get('/my-orders', MyOrdersPage::class)->name('orders.index');
Route::get('/orders/{order:order_number}', OrderTrackingPage::class)->name('orders.show');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware(['auth:staff', 'staff'])->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/products', ProductManager::class)->name('products');
    Route::get('/hubs', HubManager::class)->name('hubs');
    Route::get('/orders', OrderManager::class)->name('orders');
    Route::get('/customers', CustomerManager::class)->name('customers');
    Route::get('/categories', CategoryManager::class)->name('categories');
    Route::get('/staff', StaffManager::class)->name('staff');
    Route::get('/settings', SettingsForm::class)->name('settings');
});
