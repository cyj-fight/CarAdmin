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
    Route::get('/','HomeController@index');
    Route::get('manager/select','Manager\ManageHomeController@getSelect');
    Route::post('manager/select','Manager\ManageHomeController@postSelect');
    Route::resource('manager','Manager\ManageHomeController');
    Route::resource('user','User\UserHomeController');
});

Route::get('auth/login','Auth\AuthController@getLogin');
Route::post('auth/login','Auth\AuthController@postLogin');

Route::get('auth/register','Auth\AuthController@getRegister');
Route::post('auth/register','Auth\AuthController@postRegister');

Route::get('auth/logout','Auth\AuthController@getLogout');


Route::get('/new','frontController@create');
Route::post('/new','frontController@store');