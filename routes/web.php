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

Route::get('/', 'MapController@getIndex');
// Route::post($uri, $callback);
Route::post('map/tweet', 'MapController@tweet');
Route::post('map/tweets', 'MapController@tweets');
