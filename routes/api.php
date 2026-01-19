<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/signup', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);


// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('products', ApiProductController::class);
// });


// Route::middleware('auth:sanctum')
//     ->group(function () {
//         Route::apiResource('products', ApiProductController::class);
//     });
// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('products', ApiProductController::class);
// });
