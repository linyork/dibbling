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
Route::get('dibbling/{videoId}','dibbling@dibbling');
Route::get('player/playing-id', 'player@playing_id');
Route::get('player/playing/{id}', 'player@playing');
Route::get('player/list', 'player@list');
Route::get('player/played-list', 'player@play_list');
Route::get('player/delete/{id}', 'player@delete');
Route::get('player/random/', 'player@random');
