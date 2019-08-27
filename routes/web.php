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

// page
Route::get('/', 'dibbling@index');
Route::get('dibbling', 'dibbling@index');
Route::get('player', 'player@index');

// api
Route::group(['prefix' => 'v1'], function () {
    Route::get('list', 'v1\ListController@index');
    Route::get('list/{action}', 'v1\ListController@show');
    Route::post('list','v1\ListController@store');
    Route::delete('list/{id}', 'v1\ListController@destroy');
    
    Route::get('playing', 'v1\PlayingController@show');
    Route::post('playing', 'v1\PlayingController@store');
});
