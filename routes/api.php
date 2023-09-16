<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use \App\Http\Controllers\Api\CommentsComtroller;
use \App\Http\Controllers\Api\RateController;
use \App\Http\Controllers\Api\FollowerController;
use \App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionCommentController;
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

    Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
    Route::get('/sub-categories', [HomeController::class, 'subCategories'])->name('subCategories');
    Route::get('/countries', [HomeController::class, 'Countries'])->name('categories');
    Route::get('/cities', [HomeController::class, 'Cities'])->name('cities');
    Route::get('/states', [HomeController::class, 'States'])->name('states');
    Route::get('/currencies', [HomeController::class, 'Currencies'])->name('Currencies');

    Route::get('/products', [HomeController::class, 'products'])->name('products');

    Route::middleware('guest')->group(function () {

        Route::get('/settings', [HomeController::class, 'settings']);

        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);
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

        Route::get('/home', [HomeController::class, 'index']);

        Route::get('/user-products', [HomeController::class, 'UserProducts'])->name('UserProducts');
        Route::get('/product-details', [HomeController::class, 'productDetails'])->name('productsDetails');
        Route::post('store-product',[HomeController::class,'storeProduct'])->name('storeProduct');
        Route::post('store-favorite',[HomeController::class,'storeFavorite'])->name('storeFavorite');

        // Products Comments
        Route::get('/comments', [CommentsComtroller::class, 'index'])->name('comments');
        Route::get('/comments-details', [CommentsComtroller::class, 'commentDetails'])->name('commentDetails');
        Route::post('/store-comment', [CommentsComtroller::class, 'storeComment'])->name('storeComment');
        Route::post('/delete-comment', [CommentsComtroller::class, 'deleteComment'])->name('deleteComment');

        Route::get('/rates', [RateController::class, 'index'])->name('comments');
        Route::post('/store-rate', [RateController::class, 'storeRate'])->name('storeRate');
        Route::post('/delete-rate', [RateController::class, 'deleteRate'])->name('deleteRate');

        Route::post('/store-follower', [FollowerController::class, 'storeFollower'])->name('storeFollower');
        Route::post('/delete-follower', [FollowerController::class, 'deleteFollower'])->name('deleteFollower');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notification/delete', [NotificationController::class, 'DeleteNotification'])->name('notification.delete');

        Route::get('/questions', [QuestionController::class, 'index'])->name('comments');
        Route::post('/store-question', [QuestionController::class, 'storeQuestion'])->name('storeQuestion');
        Route::post('/delete-question', [QuestionController::class, 'deleteQuestion'])->name('deleteQuestion');

        Route::get('/question-comments', [QuestionCommentController::class, 'index'])->name('comments');
        Route::post('/store-question-comment', [QuestionCommentController::class, 'storeQuestionComment'])->name('storeQuestionComment');
        Route::post('/delete-question-comment', [QuestionCommentController::class, 'deleteQuestionComment'])->name('deleteQuestionComment');

        Route::get('/setting', [HomeController::class, 'setting'])->name('setting');

    });
});
