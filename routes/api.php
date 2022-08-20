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

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::group(['middleware' => ['jwt.verify'], 'namespace' => 'Api'], function () {
        Route::group(['prefix' => 'partners'], function () {
            Route::post('/', "PartnerController@store");
            Route::get('/', "PartnerController@index");
            Route::put('/{partner}', "PartnerController@update");
            Route::get('/{partner}', "PartnerController@get");
        });

        Route::group(['prefix' => 'customers'], function () {
            Route::post('/', "CustomerController@store");
            Route::get('/', "CustomerController@index");
            Route::get('/{customer}', "CustomerController@get");
            Route::put('/{customer}', "CustomerController@update");
        });

        Route::group(['prefix' => 'relations'], function () {
            Route::get('/', "RelationPriceController@index");
        });

        Route::group(['prefix' => 'quotes'], function () {
            Route::post('/', "QuoteController@store");
            Route::get('/', "QuoteController@index");
        });

        Route::group(['prefix' => 'users'], function () {
            Route::post('/', "UserController@store");
            Route::get('/', "UserController@index");
            Route::get('/{user}', "UserController@get");
        });
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::get('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
});
