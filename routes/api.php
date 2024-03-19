<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register'])->name('register');
Route::post('login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
});

Route::get('/products/search', [\App\Http\Controllers\ProductController::class, 'search']);
Route::get('/products/recommendations', [\App\Http\Controllers\ProductController::class, 'recommendations']);
Route::resource('/products', \App\Http\Controllers\ProductController::class)->only('show');

Route::resource('/categories', \App\Http\Controllers\Api\Product\CategoryController::class)->only('index');
Route::resource('/brands', \App\Http\Controllers\BrandController::class)->only('index');

// api/carts
Route::prefix('carts')->middleware('auth:api')->group(function () {
    Route::get('', [\App\Http\Controllers\Api\Checkout\Cart\CartController::class, 'index']);
    Route::get('items-count', [\App\Http\Controllers\Api\Checkout\Cart\CartController::class, 'itemsCount']);

    // api/carts/{cart}
    Route::prefix('{cart}')->group(function () {
        Route::patch('products/{product}/changeCount', [\App\Http\Controllers\Api\Checkout\Cart\CartProductController::class, 'changeCount']);
    });
});
