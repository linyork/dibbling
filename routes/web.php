<?php
/*
|--------------------------------------------------------------------------
| Web Routes __construct
|--------------------------------------------------------------------------
*/
App::setLocale((Cookie::get('locale')) ?? 'en');
$userMiddlewareArray = ['auth'];
if(\App::environment('production')) $userMiddlewareArray[] = 'verified';

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
Route::get('set_locale/{locale}', 'Set@locale')->name('set_locale');
Route::get('set_mode/{mode}', 'Set@mode')->name('set_mode');
Route::get('/', function (){ return redirect('dibbling'); })->name('home');
Route::get('player', function (){ return view('player'); })->name('player');
Route::middleware($userMiddlewareArray)->group(function () {
    Route::get('dibbling','Dibbling@index')->name('dibbling');
    Route::get('dibbling_list','DibblingList@index')->name('dibbling_list');
    Route::get('dibbling_record','DibblingRecord@index')->name('dibbling_record');
    Route::get('setting', 'Setting@index')->name('setting');
    Route::get('admin_interface', 'AdminInterface@index')->middleware('can:admin')->name('admin_interface');
});
Auth::routes(['verify' => \App::environment('production')]);
