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
            Route::post('search-select', "PartnerController@searchToSelect");
        });

        Route::group(['prefix' => 'customers'], function () {
            Route::post('/', "CustomerController@store");
            Route::get('/', "CustomerController@index");
            Route::get('search-select', "CustomerController@searchToSelect");
            Route::get('/{customer}', "CustomerController@get");
            Route::put('/{customer}', "CustomerController@update");
            Route::put('/{customer}/change-status', "CustomerController@changeStatus");
        });

        Route::group(['prefix' => 'relations'], function () {
            Route::post('/', "RelationPriceController@store");
            Route::get('/{relation}', "RelationPriceController@get");
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

        Route::group(['prefix' => 'profiles'], function () {
            Route::get('search-select', "ProfileController@searchToSelect");
        });

        Route::group(['prefix' => 'fee-types'], function () {
            Route::get('search-select', "FeeTypeController@searchToSelect");
        });

        Route::group(['prefix' => 'fee-rules'], function () {
            Route::get('search-select', "FeeRuleController@searchToSelect");
        });

        Route::group(['prefix' => 'price-types'], function () {
            Route::get('search-select', "PriceTypeController@searchToSelect");
        });

        Route::group(['prefix' => 'currencies'], function () {
            Route::get('search-select', "CurrencyController@searchToSelect");
        });

        Route::group(['prefix' => 'packing-types'], function () {
            Route::get('search-select', "PackingTypeController@searchToSelect");
            Route::post('/', "PackingTypeController@store");
            Route::get('/', "PackingTypeController@index");
            Route::put('/{packing}', "PackingTypeController@update");
            Route::get('/{packing}', "PackingTypeController@get");
        });

        Route::group(['prefix' => 'add-fees'], function () {
            Route::get('search-select', "AdditionalFeeController@searchToSelect");
            Route::post('/', "AdditionalFeeController@store");
            Route::get('/', "AdditionalFeeController@index");
            Route::put('/{addFees}', "AdditionalFeeController@update");
            Route::get('/{addFees}', "AdditionalFeeController@get");
        });

        Route::group(['prefix' => 'doc-types'], function () {
            Route::get('search-select', "DocTypeController@searchToSelect");
            Route::post('/', "DocTypeController@store");
            Route::get('/', "DocTypeController@index");
            Route::put('/{doc}', "DocTypeController@update");
            Route::get('/{doc}', "DocTypeController@get");
        });
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::get('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
});
