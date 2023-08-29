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
            Route::get('search-select', "PartnerController@searchToSelect");
            Route::get('group/search-select', "PartnerController@groupSearchToSelect");
            Route::put('/{partner}', "PartnerController@update");
            Route::get('/{partner}', "PartnerController@get");
            Route::put('/{partner}/change-status', "PartnerController@changeStatus");

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
            Route::get('by-type/{type}', "RelationPriceController@searchByType");
            Route::get('/', "RelationPriceController@index");
            Route::group(['prefix' => 'datatable'], function() {
                Route::get('/company', "RelationDataTableController@getCompanyDataTable");
                Route::get('/fenix', "RelationDataTableController@getFenixDataTable");
                Route::get('/postcode', "RelationDataTableController@getPostcodeDataTable");
                Route::get('/partner', "RelationDataTableController@getPatnerDataTable");

            });
            Route::put('/{relation}', "RelationPriceController@update");
        });

        Route::group(['prefix' => 'quotes'], function () {
            Route::post('/', "QuoteController@store");
            Route::post('/calculate', "QuoteController@calculate");
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

        Route::group(['prefix' => 'payment-types'], function () {
            Route::get('search-select', "PaymentTypeController@searchToSelect");
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


        Route::group(['prefix' => 'invoices'], function () {
            Route::get('search-select', "InvoiceController@searchToSelect");
            Route::post('/', "InvoiceController@store");
            Route::get('/', "InvoiceController@index");
            Route::put('/{invoice}', "InvoiceController@update");
            Route::get('/{invoice}', "InvoiceController@get");
        });

        Route::group(['prefix' => 'cabinets'], function () {
            Route::get('/paginate', "CabinetController@paginate");
            Route::get('/', "CabinetController@index");
            Route::post('/', "CabinetController@store");
        });

        Route::group(['prefix' => 'objects'], function () {
            Route::get('search-select', "ObjectController@searchToSelect");
            Route::get('/paginate', "ObjectController@paginate");
            Route::get('/paginate-create', "ObjectController@paginateCreate");
            Route::get('/print/{objectId}', "ObjectController@print");
        });

        Route::group(['prefix' => 'locales'], function () {
            Route::get('search-select', "LocaleController@searchToSelect");
            Route::post('/', "LocaleController@store");
            Route::get('/', "LocaleController@index");
            Route::put('/{locale}', "LocaleController@update");
            Route::get('/{locale}', "LocaleController@get");
        });

        Route::group(['prefix' => 'banks'], function () {
            Route::get('search-select', "BankController@searchToSelect");
            Route::post('/', "BankController@store");
            Route::get('/', "BankController@index");
        });

        Route::group(['prefix' => 'countries'], function () {
            Route::get('search-select', "CountryController@searchToSelect");
            Route::post('/', "CountryController@store");
            Route::get('/', "CountryController@index");
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('search-select-status', "OrderController@searchToSelectStatus");
            Route::get('search-select', "OrderController@searchByNumber");
            Route::get('/paginate-create', "OrderController@searchOrderPaginate");
            Route::get('movements/{order}', "OrderController@listMovement");
            Route::get('warnings/{order}', "OrderController@listWarnings");
            Route::post('/', "OrderController@store");
            Route::post('/movement', "OrderController@storeOrderMovement");
            Route::post('/update/movement', "OrderController@updateMovement");

            Route::post('/warning', "OrderController@storeOrderWarning");
            Route::post('/single-item', "OrderController@storeSingleItem");
            Route::get('/', "OrderController@index");
            Route::put('/{order}', "OrderController@update");
            Route::get('/{order}', "OrderController@getData");
        });
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::get('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
});
