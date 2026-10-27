<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard');
    });

    // Categories Management
    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::resource('categories', CategoryController::class);

    // Products Management
    Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::delete('/products/images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('products', ProductController::class);
});

