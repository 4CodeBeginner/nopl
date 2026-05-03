<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/product', function () {
    return view('pages.product');
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::resource('products', ProductController::class);

Route::resource('sales', SalesController::class);
Route::get('/sales-search', [SalesController::class, 'search'])->name('sales.search');
Route::get('/dashboard-stats', [SalesController::class, 'stats'])->name('dashboard.stats');
