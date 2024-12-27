<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::prefix('v1')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'get']);
        Route::get('/by-reference/{reference}', [ProductController::class, 'getProductByReference'])
            ->where('reference', '[A-Za-z]+');
        Route::post('/', [ProductController::class, 'store']);
    });
});
