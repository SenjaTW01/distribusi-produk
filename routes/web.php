<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DistributionProductController;
use App\Http\Controllers\AuthController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Distribution Routes
    Route::get('/distributions', [DistributionController::class, 'index'])->name('distributions.index');
    Route::get('/distributions/create', [DistributionController::class, 'create'])->name('distributions.create');
    Route::post('/distributions', [DistributionController::class, 'store'])->name('distributions.store');
    Route::delete('/distributions/{distribution}', [DistributionController::class, 'destroy'])->name('distributions.destroy');
    
    // Distribution Products Routes
    Route::post('/distribution-products', [DistributionProductController::class, 'store'])->name('distribution-products.store');
    Route::delete('/distribution-products/{distributionProduct}', [DistributionProductController::class, 'destroy'])->name('distribution-products.destroy');
    Route::get('/products/available', [DistributionController::class, 'getAvailableProducts'])->name('products.available');
    
    // DataTable Routes
    Route::get('/distributions/data', [DistributionController::class, 'getData'])->name('distributions.data');
    Route::get('/distributions/{id}/detail', [DistributionController::class, 'getDetail'])->name('distributions.detail');
});

Route::get('/distributions/data', [DistributionController::class, 'getData'])->name('distributions.data');
Route::get('/distributions/{id}/detail', [DistributionController::class, 'getDetail'])->name('distributions.detail');
Route::get('/distribution-products/available', [DistributionController::class, 'getAvailableProducts'])->name('distribution-products.available');

// Endpoint untuk produk sementara
Route::post('/distribution-products', [DistributionProductController::class, 'store'])->name('distribution-products.store');
Route::delete('/distribution-products/{id}', [DistributionProductController::class, 'destroy'])->name('distribution-products.destroy');
