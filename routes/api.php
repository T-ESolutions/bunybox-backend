<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\AddressesController;
use App\Http\Controllers\Api\OffersController;

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
    Route::get('/settings-contact_us', [SettingsController::class, 'settingsContactUs']);
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
//            Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm']);
//            Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm']);
        });

        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::get('/offers', [OffersController::class, 'offers'])->name('offers');
        Route::post('/save-sizes-data', [HomeController::class, 'saveSizesData'])->name('saveSizesData');
        Route::post('/save-sizes-data-refresh/{id}', [HomeController::class, 'saveSizesDataBox'])->name('saveSizesDataRefresh');

        Route::get('/execute_pay', [HomeController::class, 'executePay']);

    });
    Route::group(['middleware' => ['user']], function () {
        Route::get('/delete-account', [AuthController::class, 'deleteAccount']);

        Route::prefix('auth')->group(function () {
//            Route::post('/change-password', [AuthController::class, 'changePassword'])->name('client.change.password');
            Route::get('/logout', [AuthController::class, 'logout'])->name('client.logout');
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::post('/profile/update', [AuthController::class, 'profileUpdate']);
            Route::post('/profile/update_sizes', [AuthController::class, 'profileUpdateSizes']);
        });
        Route::group(['prefix' => "addresses"], function () {
            //addresses
            Route::get('/', [AddressesController::class, 'index']);
            Route::get('/details', [AddressesController::class, 'details']);
            Route::post('/store', [AddressesController::class, 'store']);
            Route::post('/update', [AddressesController::class, 'update'])->name('addresses.update');
            Route::post('/make-default', [AddressesController::class, 'makeDefault']);
            Route::post('/delete', [AddressesController::class, 'delete']);
        });


        Route::group(['prefix' => "orders"], function () {
            //addresses
            Route::post('/place-order', [OrderController::class, 'placeOrder']);
            Route::get('/orders', [OrderController::class, 'orders']);
            Route::get('/order-details/{id}', [OrderController::class, 'orderDetails']);
            Route::post('/store-transaction-id', [OrderController::class, 'storeOrderTransactionId']);
            Route::post('/pay-order', [OrderController::class, 'payOrder']);
            Route::get('/generate-payment-link', [OrderController::class, 'generatePaymentLink']);

        });



    });
});
