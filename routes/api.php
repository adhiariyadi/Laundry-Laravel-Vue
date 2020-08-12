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

Route::prefix('v1')->group(function () {
    Route::middleware('cors')->group(function () {
        Route::post('/login', 'API\AuthController@login');

        Route::middleware('auth:api')->group(function () {
            Route::get('/user', 'API\AuthController@user');
            Route::post('/logout', 'API\AuthController@logout');

            Route::resource('/antrian', 'API\AntrianController');
            Route::resource('/room', 'API\RoomController');
            Route::post('/cekPromo', 'API\RoomController@promo');
            Route::post('/kembali', 'API\RoomController@kembali');
            Route::post('/selesai', 'API\RoomController@selesai');
            Route::post('/ambil', 'API\RoomController@ambil');
            Route::resource('/pembayaran', 'API\PembayaranController');

            Route::resource('/category', 'API\CategoryController');
            Route::resource('/member', 'API\MemberController');
            Route::resource('/promo', 'API\PromoController');
            Route::resource('/pengeluaran', 'API\PengeluaranController');
            Route::get('/tahun', 'API\LaporanController@tahun');
            Route::get('/bulan', 'API\LaporanController@bulan');
            Route::get('/tanggal', 'API\LaporanController@tanggal');
            Route::get('/detail', 'API\LaporanController@detail');
            Route::get('/kas', 'API\LaporanController@kas');
            Route::resource('/setting', 'API\SettingController');
        });
    });
});
