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


//Auth::routes();


Route::middleware(['auth'])->group(function(){

    //메모 테스트
    Route::resource('memo', 'App\Http\Controllers\MemoController');

});


//외부 인덱스
Route::get('/', function () {return view('welcome');});


//로그인폼
Route::get('auth/login', [
    'as' => 'auth.login',
    'uses' => 'App\Http\Controllers\login\LoginController@getLogin'
]);

//로그인 처리
Route::post('auth/login',[
    'as' => 'auth.logindo'
    , 'uses' =>  'App\Http\Controllers\login\LoginController@postLogin'
]);

//로그아웃
Route::match(['post','get'], 'auth/logout', [
    'as' => 'auth.logoutdo',
    'uses' => 'App\Http\Controllers\login\LoginController@postLogout'
]);

//회원가입 폼
Route::get('auth/register', [
   'as' => 'auth.register',
   'uses' => 'App\Http\Controllers\join\JoinController@getRegister'
]);

//회원가입 처리
Route::post('auth/register',[
    'as' => 'auth.registerdo',
    'uses' => 'App\Http\Controllers\join\JoinController@postRegister'
]);


//메인화면
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('adminmiddle');



//관리자 권한 메뉴
Route::middleware(['adminmiddle'])->group(function(){

    //멤버관리 리스트
    Route::match(['get','post'],'member/list',[
        'as' => 'member.list',
        'uses' => 'App\Http\Controllers\member\MemberController@list'
    ]);


});






Route::match(['get','post'],'/test/main', 'App\Http\Controllers\test\MainController@main');

Route::get('/test/hello', 'App\Http\Controllers\test\MainController@hello');

Route::get('/test/bye', 'App\Http\Controllers\test\MainController@bye');

Route::get('/test/project', 'App\Http\Controllers\test\MainController@project');


