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

    // user
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('/user/add', [\App\Http\Controllers\UserController::class, 'store']);
    Route::delete('/user/delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
    Route::put('/user/edit/{user}', [\App\Http\Controllers\UserController::class, 'update']);
    // profile
    Route::put('/user/profile/edit/{user_id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::get('/user/details/{user_id}', [\App\Http\Controllers\UserController::class, 'show']);

});

Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'resetPassword']);
Route::post('/verify/pin', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyPin']);
