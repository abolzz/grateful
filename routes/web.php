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
// Route::get('/profils', 'PagesController@profile');

Route::resource('piedavajumi', 'ListingsController');
Route::resource('veikali', 'ShopsController');

Auth::routes(['verify' => true]);

Route::get('/dashboard', 'DashboardController@index');

Route::post('/payment', 'PaymentController@index');
Route::get('/payment', 'PaymentController@show');

Route::get('profils', 'ChangePasswordController@index');
Route::post('profils', 'ChangePasswordController@store')->name('change.password');

Route::get('/fb-login', 'SocialAuthFacebookController@redirect');
Route::get('/veikali', 'SocialAuthFacebookController@callback');
