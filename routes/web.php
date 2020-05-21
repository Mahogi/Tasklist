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

Route::resource('task', 'TaskController')->except(['show']);
Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::post('/main/register', 'MainController@register');
Route::get('/main/successlogin', 'MainController@successlogin');
Route::get('/main/logout', 'MainController@logout');

Route::get('/main/changePass', 'UserController@changePass');
Route::get('/main/editPass', 'UserController@editPass');
Route::get('/main/deleteAccount', 'UserController@deleteAccount');

Route::get('/task/complete', 'TaskController@complete');

//change password
//make admin account per seeds
//make task complete - done
//delete account
//auth routes...
//make new controllers for tasklist (middleware->user), and for delete account / change password (middleware->user)
