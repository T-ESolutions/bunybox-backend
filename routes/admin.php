<?php

use App\Http\Controllers\Admin\OperationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ZoneController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('Login', [\App\Http\Controllers\frontController::class, 'login']);
Route::get('logout', [\App\Http\Controllers\frontController::class, 'logout']);

Route::get('forget-password', [\App\Http\Controllers\frontController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [\App\Http\Controllers\frontController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}/{email}', [\App\Http\Controllers\frontController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [\App\Http\Controllers\frontController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['middleware' => ['admin']], function () {

    Route::get('Setting', [\App\Http\Controllers\Admin\AdminsController::class, 'Setting'])->name('profile');
    Route::post('UpdateProfile', [\App\Http\Controllers\Admin\AdminsController::class, 'UpdateProfile'])->name('UpdateProfile');

    Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');


//    Route::group(['prefix' => 'users', 'as' => 'users'], function () {
//
//        Route::get('/', [UsersController::class, 'index'])->name('.index');
//        Route::get('/datatable', [UsersController::class, 'datatable'])->name('.datatable');
//        Route::get('/add-button', [UsersController::class, 'table_buttons'])->name('.add-button');
//        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('.edit');
//        Route::post('/update/{id}', [UsersController::class, 'update'])->name('.update');
//        Route::post('/store', [UsersController::class, 'store'])->name('.store');
//        Route::get('/delete', [UsersController::class, 'destroy'])->name('.delete');
//        Route::post('/change_active', [UsersController::class, 'changeActive'])->name('.change_active');
//
//    });

    Route::group(['prefix' => 'admins', 'as' => 'admins'], function () {

        Route::get('/', [AdminsController::class, 'index'])->name('.index');
        Route::get('/datatable', [AdminsController::class, 'datatable'])->name('.datatable');
        Route::get('/add-button', [AdminsController::class, 'table_buttons'])->name('.add-button');
        Route::get('/edit/{id}', [AdminsController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [AdminsController::class, 'update'])->name('.update');
        Route::post('/store', [AdminsController::class, 'store'])->name('.store');
        Route::get('/delete', [AdminsController::class, 'destroy'])->name('.delete');
        Route::post('/change_active', [AdminsController::class, 'changeActive'])->name('.change_active');

    });
    Route::group(['prefix' => 'operations', 'as' => 'operations'], function () {

        Route::get('/', [OperationsController::class, 'index'])->name('.index');
        Route::get('/datatable', [OperationsController::class, 'datatable'])->name('.datatable');
        Route::get('/add-button', [OperationsController::class, 'table_buttons'])->name('.add-button');
        Route::get('/create', [OperationsController::class, 'create'])->name('.create');
        Route::get('/edit/{id}', [OperationsController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [OperationsController::class, 'update'])->name('.update');
        Route::post('/store', [OperationsController::class, 'store'])->name('.store');
        Route::get('/delete', [OperationsController::class, 'destroy'])->name('.delete');
        Route::post('/change_active', [OperationsController::class, 'changeActive'])->name('.change_active');

    });


    Route::group(['prefix' => 'zones', 'as' => 'zones'], function () {
        Route::get('/', [ZoneController::class, 'index'])->name('.index');
        Route::get('/create', [ZoneController::class, 'create'])->name('.create');
        Route::get('getData', [ZoneController::class, 'getData'])->name('.datatable');
        Route::post('/store', [ZoneController::class, 'store'])->name('.store');
        Route::get('get-all-zone-cordinates/{id?}', [ZoneController::class, 'get_all_zone_cordinates'])->name('.zoneCoordinates');
        Route::post('search', [ZoneController::class, 'search'])->name('.search');

        Route::get('/edit/{id}', [ZoneController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [ZoneController::class, 'update'])->name('.update');

        Route::post('/delete', [ZoneController::class, 'delete'])->name('.delete');

    });

});
