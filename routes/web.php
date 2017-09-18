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

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\\V1'], function(){
    Route::get('/users/me', 'UsersController@me');
});

Auth::routes();