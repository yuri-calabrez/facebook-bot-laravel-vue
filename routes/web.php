<?php

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

Route::get('/', function () {
	return view('welcome');
});

Route::group(['prefix' => 'bot'], function(){
	Route::get('/webhook', 'BotController@subscribe');
	Route::post('/webhook', 'BotController@receiveMessage');
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\\V1', 'middleware' => 'auth'], function(){
    Route::post('/postbacks/get-started-button/{id}', 'PostbacksController@setGetStartedButton');
    Route::delete('/postbacks/get-started-button', 'PostbacksController@removeGetStartedButton');
    Route::resource('/postbacks', 'PostbacksController');

    Route::post('/messages/{id}/product', 'MessagesController@product');
    Route::delete('/messages/{id}/product/{product_id}', 'MessagesController@deleteProduct');
    Route::get('/messages/{id}/product', 'MessagesController@getProduct');

    Route::resource('/messages', 'MessagesController');
    Route::resource('/elements', 'ElementsController');
    Route::resource('/products', 'ProductsController');
});


Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\\V1'], function(){
    Route::get('/users/me', 'UsersController@me');
});

Auth::routes();