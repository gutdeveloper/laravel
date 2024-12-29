<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'get']);
        Route::get('/by-reference/{reference}', [ProductController::class, 'getProductByReference'])
            ->where('reference', '[A-Za-z]+');
        Route::post('/', [ProductController::class, 'store']);
        Route::post('/{productId}/images', [ProductController::class, 'saveImages']);
    });
    Route::prefix('product-variants')->group(function () {
        Route::post('/', [ProductVariantsController::class, 'store']);
    });
});
