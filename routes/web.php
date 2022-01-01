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
Route::get('/AuthUser', 'HomeController@auth_user');
Route::get('/calculate', 'HomeController@calculate')->name('calculate');
Route::post('/calculate', 'HomeController@calculate')->name('calculate');

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->name('linelogin');
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// LINE メッセージ受信
Route::get('/line/webhook', 'LineMessengerController@webhook')->name('line.webhook');
Route::post('/line/webhook', 'LineMessengerController@webhook')->name('line.webhook');


// LINE メッセージ送信用
Route::get('/line/message', 'LineMessengerController@message');
Route::get('/alternative_pay_action', 'LineMessengerController@try_session_data');
Route::get('/pay_action_amount/{number}', 'LineMessengerController@try_session_data_amount');
Route::get('/subtraction', 'CalculateController@subtraction');
Route::get('/payedAction', 'CalculateController@payedAction');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
