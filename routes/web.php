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

//메인 인덱스
Route::get('/', function () {return view('welcome');});


//로그인폼
Route::get('auth/login', [
    'as' => 'auth.create',
    'uses' => 'App\Http\Controllers\login\LoginController@getLogin'
]);

//로그인 처리
Route::post('auth/login',[
    'as' => 'auth.store'
    , 'uses' =>  'App\Http\Controllers\login\LoginController@postLogin'
]);

//로그아웃
Route::get('auth/logout', [
    'as' => 'auth.destory',
    'uses' => 'App\Http\Controllers\login\LoginController@getLogout'
]);

//회원가입 폼
Route::get('auth/register', [
   'as' => 'auth.register',
   'uses' => 'App\Http\Controllers\Auth\RegisterController@show'
]);

//회원가입 처리
Route::post('auth/register',[
    'as' => 'join.create',
    'uses' => 'App\Http\Controllers\join\JoinController@create'
]);





Route::match(['get','post'],'/test/main', 'App\Http\Controllers\test\MainController@main');

Route::get('/test/hello', 'App\Http\Controllers\test\MainController@hello');

Route::get('/test/bye', 'App\Http\Controllers\test\MainController@bye');

Route::get('/test/project', 'App\Http\Controllers\test\MainController@project');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('memo', 'App\Http\Controllers\MemoController');

