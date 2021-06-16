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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');

        Route::get('/liveSituation', 'AdminController@liveSituation');

        Route::get('/parkingList', 'AdminController@parkingList');

        Route::get('/feeGraph', 'AdminController@feeGraph');

        Route::get('/feeGraphWeek', 'AdminController@feeGraphWeek');

        Route::get('/feeGraphMonth', 'AdminController@feeGraphMonth');

        Route::get('/feeUpdate', 'AdminController@feeUpdate');

        Route::get('/searchFee', 'AdminController@searchFee');

        Route::get('/totalCarList', 'AdminController@totalCarList');

    });
});

Route::get('/checkSpace', 'UserController@checkSpace');

Route::get('/locationCar', 'UserController@locationCar');

Route::get('/entryCar', 'AccessController@entryCar');

Route::get('/detectionNewCar', 'AccessController@detectionNewCar');

Route::get('/exitCar', 'AccessController@exitCar');

Route::post('/carParked', 'RoutingController@carParked');
