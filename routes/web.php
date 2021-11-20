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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/cart/store', 'CartController@store')->name('cart.store');
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart/destroy', 'CartController@destroy')->name('cart.destroy');
Route::post('/order/store', 'OrderController@store')->name('order.store');
Route::get('/order/{orderId}', 'OrderController@index')->name('order.index');
Route::get('/order', 'OrderController@list')->name('order.list');
