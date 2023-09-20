<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('client')->group(function () {

    Route::middleware('guest')->group(function () {


        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/login/verify', [AuthController::class, 'verifyLogin']);
            Route::post('/sign-up', [AuthController::class, 'register']);
            Route::post('/sign-up/verify-phone', [AuthController::class, 'verifyPhone']);
            Route::post('/sign-up/resend-verify-phone', [AuthController::class, 'resendVerifyPhone']);
            Route::post('/register', [AuthController::class, 'register']);
            Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm']);
            Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm']);

        });
    });


    Route::group(['middleware' => ['user']], function () {
        Route::prefix('auth')->group(function () {
            Route::post('/change-password', [AuthController::class, 'changePassword'])->name('client.change.password');
            Route::get('/logout', [AuthController::class, 'logout'])->name('client.logout');
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::post('/profile/update', [AuthController::class, 'profileUpdate']);
        });


    });
});
