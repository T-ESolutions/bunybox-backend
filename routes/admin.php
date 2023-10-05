<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\frontController;


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
Route::post('Login', [frontController::class, 'login']);
Route::get('logout', [frontController::class, 'logout']);

Route::get('forget-password', [frontController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [frontController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}/{email}', [frontController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [frontController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['middleware' => ['admin']], function () {

    Route::get('Setting', [AdminsController::class, 'Setting'])->name('profile');
    Route::post('UpdateProfile', [AdminsController::class, 'UpdateProfile'])->name('UpdateProfile');

    Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');


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

    Route::group(['prefix' => 'products', 'as' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('.index');
        Route::get('/create', [ProductController::class, 'create'])->name('.create');
        Route::get('getData', [ProductController::class, 'getData'])->name('.datatable');
        Route::post('/store', [ProductController::class, 'store'])->name('.store');
        Route::get('get-all-zone-cordinates/{id?}', [ProductController::class, 'get_all_zone_cordinates'])->name('.zoneCoordinates');
        Route::post('search', [ProductController::class, 'search'])->name('.search');

        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('.update');

        Route::post('/delete', [ProductController::class, 'delete'])->name('.delete');

    });

});
