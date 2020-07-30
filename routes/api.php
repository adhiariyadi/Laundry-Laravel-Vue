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

            Route::resource('/category', 'API\CategoryController');
        });
    });
});
