<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

// Route::get('/product', function () {
//     return view('pages.product');
// });

Route::get('/product', [ProductController::class, 'indexUser']);

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::resource('products', ProductController::class);
