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
Route::get('/add','FrontController@create');
Route::get('/insert','FrontController@store');

Route::get('select/brand','FrontController@postSelectBrand');
Route::get('select/series','FrontController@postSelectSeries');
Route::get('select/type','FrontController@postSelectType');
Route::get('select','FrontController@postSelect');
Route::get('select/getparents','FrontController@getParents');

Route::get('admin/manager/select/brand','Admin\Manager\ManageHomeController@postSelectBrand');
Route::get('admin/manager/select/series','Admin\Manager\ManageHomeController@postSelectSeries');
Route::get('admin/manager/select/type','Admin\Manager\ManageHomeController@postSelectType');
Route::get('admin/manager/select','Admin\Manager\ManageHomeController@postSelect');
Route::get('admin/manager/select/getparents','Admin\Manager\ManageHomeController@getParents');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'auth'],function(){
    Route::get('/home','HomeController@index');

    //Route::get('manager/select/series','Manager\ManageHomeController@postSelectSeries');
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