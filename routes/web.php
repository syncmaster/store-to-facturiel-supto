<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'LoginController@index');
Route::post('/', 'LoginController@login');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::group(['middleware' => 'check.auth'], function() {
    Route::get('/factoriel', 'FactorielController@index')->name('home');
    Route::post('search', 'FactorielController@search')->name('search');
    Route::group(['prefix' => 'shops'], function() {
        Route::get('/', 'ShopController@index')->name('shops.index');
        Route::get('/edit/{id}', 'ShopController@edit')->name('shops.edit');
        Route::post('/edit/{id}', 'ShopController@update')->name('shops.update');
        Route::get('/delete/{id}', 'ShopController@delete')->name('shops.delete');
        Route::post('/delete/{id}', 'ShopController@destroy')->name('shops.destroy');
        Route::get('/create', 'ShopController@create')->name('shops.create');
        Route::post('/create', 'ShopController@store')->name('shops.store');
    });
});