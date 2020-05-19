<?php

use Illuminate\Support\Facades\Route;
//use Auth;

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

Route::get('/', function () {
    return redirect('/main');
});

//Auth::routes();

Route::resource('main', 'MainController')->except(['show']);
Route::resource('main', 'MainController');
Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::post('/main/register', 'MainController@register');
Route::get('/main/successlogin', 'MainController@successlogin');
Route::get('/main/logout', 'MainController@logout');
