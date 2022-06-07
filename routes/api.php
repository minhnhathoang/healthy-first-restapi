<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = User::where('id', Auth::user()->id)->get();
        return \App\Http\Resources\UserResource::collection($user);
    });


    Route::post('/email/verify', [\App\Http\Controllers\Auth\AuthController::class, 'verifyEmail']);

    Route::post('/password/change', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'changePassword']);

    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);

    Route::middleware('verify.api')->group(function () {

    });

    // gso

    Route::get('/provinces', [\App\Http\Controllers\GSO\ProvinceController::class, 'index']);
    Route::post('/province/districts', [\App\Http\Controllers\GSO\DistrictController::class, 'getDistrictsOfProvince']);
    Route::post('/district/communes', [\App\Http\Controllers\GSO\CommuneController::class, 'getCommunesOfDistrict']);

    // user
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('/user/add', [\App\Http\Controllers\UserController::class, 'store']);
    Route::delete('/user/delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
    Route::put('/user/edit/{user}', [\App\Http\Controllers\UserController::class, 'update']);

    Route::get('/users/export', [\App\Http\Controllers\UserController::class, 'export']);

    // profile
    Route::post('/user/profile/edit/{user_id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::get('/user/details/{user_id}', [\App\Http\Controllers\UserController::class, 'show']);

    // establishment
    Route::get('/establishments', [\App\Http\Controllers\EstablishmentController::class, 'index']);
    Route::post('/establishment/add', [\App\Http\Controllers\EstablishmentController::class, 'store']);
    Route::get('/establishment/details/{id}', [\App\Http\Controllers\EstablishmentController::class, 'show']);
    Route::post('/establishment/edit/{id}', [\App\Http\Controllers\EstablishmentController::class, 'update']);

    Route::post('/establishments/{id}', [\App\Http\Controllers\EstablishmentController::class, 'index']);
    Route::delete('/establishments/{id}', [\App\Http\Controllers\EstablishmentController::class, 'index']);

    // certificate
    Route::post('/certificate/add', [\App\Http\Controllers\CertificateController::class, 'store']);
    Route::post('/certificate/update', [\App\Http\Controllers\CertificateController::class, 'update']);
    Route::delete('/certificate/delete/{id}', [\App\Http\Controllers\CertificateController::class, 'destroy']);

    // plan


});

Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'resetPassword']);
Route::post('/verify/pin', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyPin']);


Route::post('/import/provinces', [\App\Http\Controllers\GSO\ProvinceController::class, 'import']);
Route::post('/import/districts', [\App\Http\Controllers\GSO\DistrictController::class, 'import']);
Route::post('/import/communes', [\App\Http\Controllers\GSO\CommuneController::class, 'import']);
