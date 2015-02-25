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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('10k/{ticker}', 'DataController@index');

Route::get('load', 'DataController@loadTickers');

Route::get('show', 'DataController@showTickers');

Route::get('spin', 'DataController@spin');

Route::get('holders', 'DataController@spinHolders');

Route::get('mark/{id}', 'DataController@markHolder');

Route::get('download', 'DataController@getDownload');