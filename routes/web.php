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


    //강사신청관리 리스트
    Route::match(['get','post'],'application/list',[
        'as' => 'mgmt.application.list',
        'uses' => 'App\Http\Controllers\mgmt\application\ApplicationController@list'
    ]);

    //강사신청관리 상세화면
    Route::match(['get','post'],'application/read',[
        'as' => 'mgmt.application.read',
        'uses' => 'App\Http\Controllers\mgmt\application\ApplicationController@read'
    ]);

    //강사신청관리 수정화면
    Route::match(['get','post'],'application/update',[
        'as' => 'mgmt.application.update',
        'uses' => 'App\Http\Controllers\mgmt\application\ApplicationController@update'
    ]);

    //강사신청관리 수정
    Route::match(['get','post'],'application/updateDo',[
        'as' => 'mgmt.application.updateDo',
        'uses' => 'App\Http\Controllers\mgmt\application\ApplicationController@updateDo'
    ]);

    //강사신청관리 승인
    Route::match(['get','post'],'application/approval',[
        'as' => 'mgmt.application.approval',
        'uses' => 'App\Http\Controllers\mgmt\application\ApplicationController@approval'
    ]);

    //강사신청관리 삭제
    Route::match(['get','post'],'application/delete',[
        'as' => 'mgmt.application.delete',
        'uses' => 'App\Http\Controllers\mgmt\application\ApplicationController@delete'
    ]);




    //멤버관리 리스트
    Route::match(['get','post'],'member/',[
        'as' => 'mgmt.member.index',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@index'
    ]);

    //멤버관리 리스트
    Route::match(['get','post'],'member/list',[
        'as' => 'mgmt.member.list',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@list'
    ]);

    //멤버관리 상세화면
    Route::match(['get','post'],'member/detail',[
        'as' => 'mgmt.member.detail',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@detail'
    ]);

    //멤버관리 수정화면
    Route::match(['get','post'],'member/modify',[
        'as' => 'mgmt.member.modify',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@modify'
    ]);

    //멤버관리 수정처리
    Route::match(['get','post'],'member/update',[
        'as' => 'mgmt.member.update',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@update'
    ]);

    //멤버관리 승인처리
    Route::match(['get','post'],'member/updateApproval',[
        'as' => 'mgmt.member.updateApproval',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@updateApproval'
    ]);

    //멤버관리 삭제처리
    Route::match(['get','post'],'member/deleteUser',[
        'as' => 'mgmt.member.deleteUser',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@deleteUser'
    ]);



    //수요처관리 리스트 화면
    Route::match(['get','post'],'mgmt/client/list',[
        'as' => 'mgmt.client.list',
        'uses' => 'App\Http\Controllers\mgmt\client\ClientController@list'
    ]);

    //수요처관리 등록 화면
    Route::match(['get','post'],'mgmt/client/create',[
        'as' => 'mgmt.client.create',
        'uses' => 'App\Http\Controllers\mgmt\client\ClientController@create'
    ]);

    //수요처관리 등록
    Route::match(['get','post'],'mgmt/client/createDo',[
        'as' => 'mgmt.client.createDo',
        'uses' => 'App\Http\Controllers\mgmt\client\ClientController@createDo'
    ]);

    //수요처관리 상세 화면
    Route::match(['get','post'],'mgmt/client/read',[
        'as' => 'mgmt.client.read',
        'uses' => 'App\Http\Controllers\mgmt\client\ClientController@read'
    ]);

    //수요처관리 수정 화면
    Route::match(['get','post'],'mgmt/client/update',[
        'as' => 'mgmt.client.update',
        'uses' => 'App\Http\Controllers\mgmt\client\ClientController@update'
    ]);

    //수요처관리 수정
    Route::match(['get','post'],'mgmt/client/updateDo',[
        'as' => 'mgmt.client.updateDo',
        'uses' => 'App\Http\Controllers\mgmt\client\ClientController@updateDo'
    ]);


    //계약관리 등록 화면
    Route::match(['get','post'],'mgmt/contract/create',[
        'as' => 'mgmt.contract.create',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@create'
    ]);

    //계약관리 등록
    Route::match(['get','post'],'mgmt/contract/createDo',[
        'as' => 'mgmt.contract.createDo',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@createDo'
    ]);

    //계약관리 상세 화면
    Route::match(['get','post'],'mgmt/contract/read',[
        'as' => 'mgmt.contract.read',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@read'
    ]);

    //계약관리 목록 화면
    Route::match(['get','post'],'mgmt/contract/list',[
        'as' => 'mgmt.contract.list',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@list'
    ]);

    //계약관리 수정 화면
    Route::match(['get','post'],'mgmt/contract/update',[
        'as' => 'mgmt.contract.update',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@update'
    ]);

    //계약관리 수정
    Route::match(['get','post'],'mgmt/contract/updateDo',[
        'as' => 'mgmt.contract.updateDo',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@updateDo'
    ]);




});




//관리자 + 메니저 권한 메뉴
Route::middleware(['managermiddle'])->group(function(){

    //강좌 배정 목록
    Route::match(['get','post'],'grade/lecture/list',[
        'as' => 'grade.lecture.list',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@list'
    ]);


    //강좌 배정 목록
    Route::match(['get','post'],'grade/lecture/read',[
        'as' => 'grade.lecture.read',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@read'
    ]);


    //사용자 목록 팝업
    Route::match(['get','post'],'grade/lecture/popupUser',[
        'as' => 'grade.lecture.popupUser',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@popupUser'
    ]);


    //사용자 매칭 업데이트
    Route::match(['get','post'],'grade/lecture/updateUser',[
        'as' => 'grade.lecture.updateUser',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@updateUser'
    ]);


});




Route::match(['get','post'],'/test/main', 'App\Http\Controllers\test\MainController@main');

Route::get('/test/hello', 'App\Http\Controllers\test\MainController@hello');

Route::get('/test/bye', 'App\Http\Controllers\test\MainController@bye');

Route::get('/test/frame', 'App\Http\Controllers\test\MainController@frame');

Route::get('/test/project', 'App\Http\Controllers\test\MainController@project');


