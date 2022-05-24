<?php

use Illuminate\Http\Request;
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

Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);

// protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/email/verify', [\App\Http\Controllers\Auth\AuthController::class, 'verifyEmail']);

    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);

    Route::middleware('verify.api')->group(function () {

    });
});

Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'resetPassword']);
Route::post('/verify/pin', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyPin']);
