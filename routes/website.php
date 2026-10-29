<?php

use App\Http\Controllers\Website\WebsiteController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [WebsiteController::class, 'home'])->name('website.home');

// Products & Categories Catalog
Route::get('/products', [WebsiteController::class, 'products'])->name('website.products.index');
Route::get('/products/{product:slug}', [WebsiteController::class, 'productShow'])->name('website.products.show');
Route::get('/categories/{category:slug}', [WebsiteController::class, 'category'])->name('website.categories.show');

// Portfolio / Projects Showcase
Route::get('/portfolio', [WebsiteController::class, 'portfolios'])->name('website.portfolios.index');

// About Us & Contact / Custom Quote
Route::get('/about', [WebsiteController::class, 'about'])->name('website.about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('website.contact');

// Submit Quote Request
Route::post('/quote-request', [WebsiteController::class, 'storeQuote'])
    ->middleware('throttle:15,1')
    ->name('website.quote.store');

