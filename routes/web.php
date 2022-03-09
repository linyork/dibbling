<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes __construct
|--------------------------------------------------------------------------
*/
App::setLocale((Cookie::get('locale')) ?? 'en');
$userMiddlewareArray = ['auth'];
if(App::environment('production')) $userMiddlewareArray[] = 'verified';

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
// auth
Auth::routes(['verify' => App::environment('production')]);

// set block
Route::get('set_locale/{locale}', [Controllers\Set::class, 'locale'])
    ->name('set_locale');
Route::get('set_mode/{mode}', [Controllers\Set::class, 'mode'])
    ->name('set_mode');

// web block
Route::get('/', function (){ return redirect('dibbling'); })
    ->name('home');
Route::view('player', 'player')
    ->name('player');

// user web block
Route::middleware($userMiddlewareArray)->group(function () {
    Route::get('supporter', [Controllers\Supporter::class, 'index'])
        ->name('supporter');
    Route::get('dibbling', [Controllers\Dibbling::class, 'index'])
        ->name('dibbling');
    Route::get('dibbling_list', [Controllers\DibblingList::class, 'index'])
        ->name('dibbling_list');
    Route::get('dibbling_record', [Controllers\DibblingRecord::class, 'index'])
        ->name('dibbling_record');
    Route::get('dibbling_like', [Controllers\DibblingLike::class, 'index'])
        ->name('dibbling_like');
    Route::get('timeline', [Controllers\Timeline::class, 'index'])
        ->name('timeline');
    Route::post('timeline', [Controllers\Timeline::class, 'index'])
        ->name('timeline_search');
    Route::get('setting', [Controllers\Setting::class, 'index'])
        ->name('setting');
    Route::get('admin_interface', [Controllers\AdminInterface::class, 'index'])
        ->middleware('can:admin')
        ->name('admin_interface');
});
