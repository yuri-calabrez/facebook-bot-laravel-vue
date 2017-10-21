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
    Route::resource('menus', 'MenusController');
    Route::get('/menus/set-menu/{menuId}', 'MenusController@setMenu');
    Route::get('/menus/remove-menu', 'MenusController@removeMenu');
    Route::resource('menu-buttons', 'MenuButtonsController');

    Route::post('/postbacks/get-started-button/{id}', 'PostbacksController@setGetStartedButton');
    Route::delete('/postbacks/get-started-button', 'PostbacksController@removeGetStartedButton');
    Route::resource('/postbacks', 'PostbacksController');

    Route::post('/messages/{id}/product', 'MessagesController@product');
    Route::delete('/messages/{id}/product/{product_id}', 'MessagesController@deleteProduct');
    Route::get('/messages/{id}/product', 'MessagesController@getProduct');

    Route::resource('/messages', 'MessagesController');
    Route::resource('/elements', 'ElementsController');
    Route::resource('/products', 'ProductsController');

    Route::resource('/suggestions', 'SuggestionsController');
});


Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\\V1'], function(){
    Route::get('/users/me', 'UsersController@me');
});

Auth::routes();