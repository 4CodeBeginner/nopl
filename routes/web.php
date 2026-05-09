<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;



Route::get('/', function () {

    $products = Product::latest()->take(12)->get();

    return view('pages.home', compact('products'));

});

Route::get('/product', [ProductController::class, 'indexUser']);

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['admin'])->group(function () {

    Route::resource('products', ProductController::class);

    Route::resource('sales', SalesController::class);

    Route::get('/sales-search', [SalesController::class, 'search'])
        ->name('sales.search');

    Route::get('/dashboard-stats', [SalesController::class, 'stats'])
        ->name('dashboard.stats');
});
