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

Route::group(['middleware' => 'auth'], function ()
{

    // home
    Route::get('/', function ()
        {
            return redirect('dibbling');
        }
    );
    // dibbling
    Route::get('dibbling', function ()
        {
            return view('dibbling');
        }
    )->name('dibbling');
});

// player
Route::get('player', function ()
{
    return view('player');
}
)->name('player');

Auth::routes();
