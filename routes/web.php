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

Route::get('/', 'ShopsController@index');
Route::get('/karte', 'PagesController@map');
Route::get('/pirkumi', 'PagesController@purchases');
Route::get('/profils', 'PagesController@profile');

Route::resource('piedavajumi', 'ListingsController');
Route::resource('veikali', 'ShopsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
