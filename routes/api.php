<?php

use Illuminate\Http\Request;

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
    'middleware' => ['api', 'cors'],
    // 'namespace' => $this->namespace,
    // 'prefix' => 'api',
], function ($router) {
     //Category
    Route::get('category', 'CategoriController@index');
    Route::get('category/edit/{id}', 'CategoriController@show');
    Route::post('category', 'CategoriController@store');
    Route::post('category/{id}', 'CategoriController@update');
    Route::get('category/{id}', 'CategoriController@destroy');


   //Category Tiket
    Route::get('katiket', 'KategoritiketController@index');
    Route::get('katiket/edit/{id}', 'KategoritiketController@show');
    Route::post('katiket', 'KategoritiketController@store');
    Route::post('katiket/{id}', 'KategoritiketController@update');
    Route::get('katiket/{id}', 'KategoritiketController@destroy');



       //Tiket
  

       Route::get('tiket', 'TiketController@index');
    Route::get('tiket/edit/{id}', 'TiketController@edit');
    Route::get('tiket/show/{id}', 'TiketController@show');
    Route::post('tiket', 'TiketController@store');
    Route::post('tiket/{id}', 'TiketController@update');
    Route::get('tiket/{id}', 'TiketController@destroy');




// Transfer
    Route::get('transfer', 'TransferController@index');
    Route::get('transfer/edit/{id}', 'TransferController@show');
    Route::post('transfer', 'TransferController@store');
    Route::post('transfer/{id}', 'TransferController@update');
   Route::post('transfer/verify/{id}', 'TransferController@publish');
    Route::get('transfer/{id}', 'TransferController@destroy');
    Route::get('transfer/recent/{id}', 'TransferController@recent');
    Route::get('transfer/reply/{id}', 'TransferController@reply');

// Event
   Route::get('event', 'EventController@index');
    Route::get('event/edit/{id}', 'EventController@edit');
    Route::get('event/show/{id}', 'EventController@show');
    Route::get('event/recent/{id}', 'EventController@recent');
    Route::post('event', 'EventController@store');
    Route::post('event/{id}', 'EventController@update');
    Route::post('event/verify/{id}', 'EventController@publish');
    Route::get('event/{id}', 'EventController@destroy');

    // Bank
    Route::get('bank', 'BankController@index');
    Route::get('bank/edit/{id}', 'BankController@show');
    Route::post('bank', 'BankController@store');
    Route::post('bank/{id}', 'BankController@update');
    Route::get('bank/{id}', 'BankController@destroy');

// Master Bank
    Route::get('masterbank', 'MasterBankController@index');
    Route::get('masterbank/edit/{id}', 'MasterBankController@show');
    Route::post('masterbank', 'MasterBankController@store');
    Route::post('masterbank/{id}', 'MasterBankController@update');
    Route::get('masterbank/{id}', 'MasterBankController@destroy');



    //User
    Route::get('user', 'UserController@index');
    Route::get('user/edit/{id}', 'UserController@show');
    Route::post('user', 'UserController@store');
    Route::post('user/{id}', 'UserController@update');
    Route::get('user/{id}', 'UserController@destroy');
});
