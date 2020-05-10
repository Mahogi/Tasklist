<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::post('/main/register', 'MainController@register');
Route::get('/main/successlogin', 'MainController@successlogin');
Route::get('/main/logout', 'MainController@logout');
Route::post('/main/addTask', 'MainController@addTask');
Route::post('/main/deleteTask', 'MainController@deleteTask');
Route::post('/main/editTask', 'MainController@editTask');
Route::post('/main/dbEdit', 'MainController@dbEdit');
//Route::post('edit', 'edit@editT');

