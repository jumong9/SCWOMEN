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

//로그인폼
Route::get('/login/loginform', function () {
    return view('/login/loginform');
});

Route::post('/login/login/','App\Http\Controllers\test\MainController@login');

Route::get('/', function () {return view('welcome');});

Route::match(['get','post'],'/test/main', 'App\Http\Controllers\test\MainController@main');

Route::get('/test/hello', 'App\Http\Controllers\test\MainController@hello');

Route::get('/test/bye', 'App\Http\Controllers\test\MainController@bye');

Route::get('/test/project', 'App\Http\Controllers\test\MainController@project');

