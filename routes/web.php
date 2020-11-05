<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

//로그인 처리
Route::post('/login/login/','App\Http\Controllers\login\LoginController@login');

//회원가입 폼
Route::get('/login/joinform', function () {
    return view('/login/joinform');
});

//회원가입 처리
Route::post('/login/join','App\Http\Controllers\login\LoginController@join');


Route::get('/', function () {return view('welcome');});


Route::match(['get','post'],'/test/main', 'App\Http\Controllers\test\MainController@main');

Route::get('/test/hello', 'App\Http\Controllers\test\MainController@hello');

Route::get('/test/bye', 'App\Http\Controllers\test\MainController@bye');

Route::get('/test/project', 'App\Http\Controllers\test\MainController@project');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('memo', 'App\Http\Controllers\MemoController');

