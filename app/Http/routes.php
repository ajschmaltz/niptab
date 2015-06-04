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

Route::controllers([
  'auth' => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);

Route::get('/', 'PageController@showData');

Route::get('help', 'PageController@showHelp');

Route::get('data/download', 'DownloadController@downloadData');

Route::get('tickers', 'PageController@showTickers');

Route::get('tickers/download', 'DownloadController@downloadTickers');

Route::get('tickers/upload', 'PageController@uploadTickers');

Route::post('tickers/upload', 'TickerController@uploadTickers');

Route::get('filings', 'PageController@showFilings');

Route::get('filings/download', 'DownloadController@downloadFilings');

Route::get('types', 'PageController@getTypes');

Route::get('types/create', 'PageController@createTypes');

Route::post('types/create', 'TypeController@saveType');

Route::get('types/{id}/delete', 'TypeController@deleteType');

Route::get('patterns', 'PageController@getPatterns');

Route::get('patterns/create', 'PageController@createPattern');

Route::post('patterns/create', 'PatternController@savePattern');

Route::get('patterns/test', 'PageController@testPattern');

Route::post('patterns/test', 'PatternController@testPattern');

Route::get('patterns/{id}/delete', 'PatternController@deletePattern');

Route::get('parse', 'FilingController@getParse');

Route::get('load', 'FilingController@getLoad');

Route::get('truncate', 'PageController@getTruncate');

Route::get('search', 'PageController@showSearch');