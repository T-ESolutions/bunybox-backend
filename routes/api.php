<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SettingsController;

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
Route::group(['prefix' => "app"], function () {
Route::get('pages/{type}', [SettingsController::class, 'pages']);
    Route::get('/settings', [SettingsController::class, 'settings']);
    Route::get('/settings/{key}', [SettingsController::class, 'custom_settings']);
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
        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::post('/save-sizes-data', [HomeController::class, 'saveSizesData'])->name('saveSizesData');
        Route::get('/box/details', [HomeController::class, 'boxDetails'])->name('boxDetails');


    });
});
