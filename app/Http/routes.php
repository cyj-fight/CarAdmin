<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','FrontController@index');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'auth'],function(){
    Route::get('/home','HomeController@index');

    Route::post('manager/select','Manager\ManageHomeController@postSelect');
    Route::resource('manager','Manager\ManageHomeController');
    Route::resource('user','User\UserHomeController');

    Route::get('password/email','User\PasswordController@getEmail');
    Route::post('password/email','User\PasswordController@postEmail');

    Route::get('password/reset/{token}','User\PasswordController@getReset');
    Route::post('password/reset','User\PasswordController@postReset');
});

Route::get('password/email','Auth\PasswordController@getEmail');
Route::post('password/email','Auth\PasswordController@postEmail');

Route::get('password/reset/{token}','Auth\PasswordController@getReset');
Route::post('password/reset','Auth\PasswordController@postReset');

Route::get('auth/login','Auth\AuthController@getLogin');
Route::post('auth/login','Auth\AuthController@postLogin');

Route::get('auth/register','Auth\AuthController@getRegister');
Route::post('auth/register','Auth\AuthController@postRegister');

Route::get('auth/logout','Auth\AuthController@getLogout');