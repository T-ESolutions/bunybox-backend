<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MainCategoryController;
use App\Http\Controllers\Admin\BoxController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\SettingController;
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

    Route::group(['prefix' => 'settings', 'as' => 'settings'], function () {
        Route::get('/edit', [SettingController::class, 'index'])->name('.edit');
        Route::post('/update', [SettingController::class, 'update'])->name('.update');
    });

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
        Route::post('search', [ProductController::class, 'search'])->name('.search');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('.update');
        Route::get('/delete', [ProductController::class, 'delete'])->name('.delete');
        Route::get('/add-button', [ProductController::class, 'table_buttons'])->name('.add-button');

    });

    Route::group(['prefix' => 'main_categories', 'as' => 'main_categories'], function () {
        Route::get('/', [MainCategoryController::class, 'index'])->name('.index');
        Route::get('/create', [MainCategoryController::class, 'create'])->name('.create');
        Route::get('getData', [MainCategoryController::class, 'getData'])->name('.datatable');
        Route::post('/store', [MainCategoryController::class, 'store'])->name('.store');
        Route::post('search', [MainCategoryController::class, 'search'])->name('.search');
        Route::get('/edit/{id}', [MainCategoryController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [MainCategoryController::class, 'update'])->name('.update');
        Route::post('/delete', [MainCategoryController::class, 'delete'])->name('.delete');

    });

    Route::group(['prefix' => 'categories', 'as' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('.create');
        Route::get('getData', [CategoryController::class, 'getData'])->name('.datatable');
        Route::post('/store', [CategoryController::class, 'store'])->name('.store');
        Route::post('search', [CategoryController::class, 'search'])->name('.search');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('.update');
        Route::get('/delete', [CategoryController::class, 'delete'])->name('.delete');
        Route::get('/add-button', [CategoryController::class, 'table_buttons'])->name('.add-button');


    });

    Route::group(['prefix' => 'boxes', 'as' => 'boxes'], function () {
        Route::get('/', [BoxController::class, 'index'])->name('.index');
        Route::get('/create', [BoxController::class, 'create'])->name('.create');
        Route::get('getData', [BoxController::class, 'getData'])->name('.datatable');
        Route::post('/store', [BoxController::class, 'store'])->name('.store');
        Route::post('search', [BoxController::class, 'search'])->name('.search');
        Route::get('/edit/{id}', [BoxController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [BoxController::class, 'update'])->name('.update');
        Route::get('/delete', [BoxController::class, 'delete'])->name('.delete');
        Route::get('/add-button', [BoxController::class, 'table_buttons'])->name('.add-button');

    });

    Route::group(['prefix' => 'offers', 'as' => 'offers'], function () {
        Route::get('/', [OfferController::class, 'index'])->name('.index');
        Route::get('/create', [OfferController::class, 'create'])->name('.create');
        Route::get('getData', [OfferController::class, 'getData'])->name('.datatable');
        Route::post('/store', [OfferController::class, 'store'])->name('.store');
        Route::post('search', [OfferController::class, 'search'])->name('.search');
        Route::get('/edit/{id}', [OfferController::class, 'edit'])->name('.edit');
        Route::post('/update/{id}', [OfferController::class, 'update'])->name('.update');
        Route::get('/delete', [OfferController::class, 'delete'])->name('.delete');
        Route::get('/add-button', [OfferController::class, 'table_buttons'])->name('.add-button');

    });

});
