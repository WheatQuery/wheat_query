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

Route::get('/', function () {
    return view('index');
})->middleware('certification');
include('admin.php');

Route::get('/login',function (){
    return view('auth\login');
});

Route::post('/logining','login\LoginController@logining');
Route::get('/logout','login\LoginController@logout');
Route::post('/adds','admin\WheatController@add');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
