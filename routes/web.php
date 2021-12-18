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

Route::get('/login/line', 'Auth\LoginController@redirectToProvider')->name('linelogin');
Route::get('/login/line/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// LINE メッセージ受信
Route::get('/line/webhook', 'LineMessengerController@webhook')->name('line.webhook');
Route::post('/line/webhook', 'LineMessengerController@webhook')->name('line.webhook');
 
// LINE メッセージ送信用
Route::get('/line/message', 'LineMessengerController@message');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
