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
//Route::get('/', function () {return view('welcome');});
Route::get('/', 'App\Http\Controllers\login\LoginController@getLogin' );


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

    //멤버관리 엑셀 export
    Route::match(['get','post'],'member/exportExcel',[
        'as' => 'mgmt.member.exportExcel',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@exportExcel'
    ]);

    //멤버관리 승인처리
    Route::match(['get','post'],'member/updateClassCategory',[
        'as' => 'mgmt.member.updateClassCategory',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@updateClassCategory'
    ]);

    //멤버관리 비밀번호 초기화
    Route::match(['get','post'],'member/resetPasswd',[
        'as' => 'mgmt.member.resetPasswd',
        'uses' => 'App\Http\Controllers\mgmt\member\MemberController@resetPasswd'
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

    Route::match(['get','post'],'mgmt/client/exportExcel',[
        'as' => 'mgmt.client.exportExcel',
        'uses' => 'App\Http\Controllers\mgmt\client\ClientController@exportExcel'
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

    //계약관리 상태 업데이트
    Route::match(['get','post'],'mgmt/contract/updateContractStatus',[
        'as' => 'mgmt.contract.updateContractStatus',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@updateContractStatus'
    ]);

    //계약관리 수정
    Route::match(['get','post'],'mgmt/contract/deleteDo',[
        'as' => 'mgmt.contract.deleteDo',
        'uses' => 'App\Http\Controllers\mgmt\contract\ContractController@deleteDo'
    ]);



    //강좌 배정 목록
    Route::match(['get','post'],'mgmt/lecture/list',[
        'as' => 'mgmt.lecture.list',
        'uses' => 'App\Http\Controllers\mgmt\lecture\LectureController@list'
    ]);


    //강좌 배정 상세
    Route::match(['get','post'],'mgmt/lecture/read',[
        'as' => 'mgmt.lecture.read',
        'uses' => 'App\Http\Controllers\mgmt\lecture\LectureController@read'
    ]);


    //활동일지 목록
    Route::match(['get','post'],'mgmt/acreport/list',[
        'as' => 'mgmt.acreport.list',
        'uses' => 'App\Http\Controllers\mgmt\acreport\AcReportController@list'
    ]);


    //활동일지 출력
    Route::match(['get','post'],'mgmt/acreport/printPopup',[
        'as' => 'mgmt.acreport.printPopup',
        'uses' => 'App\Http\Controllers\mgmt\acreport\AcReportController@printPopup'
    ]);

    //활동일지 상세
    Route::match(['get','post'],'mgmt/acreport/read',[
        'as' => 'mgmt.acreport.read',
        'uses' => 'App\Http\Controllers\mgmt\acreport\AcReportController@read'
    ]);

    //강사비 지급 관리
    Route::match(['get','post'],'mgmt/payment/list',[
        'as' => 'mgmt.payment.list',
        'uses' => 'App\Http\Controllers\mgmt\payment\PaymentController@list'
    ]);

    //강사비 지급
    Route::match(['get','post'],'mgmt/payment/updatePayment',[
        'as' => 'mgmt.payment.updatePayment',
        'uses' => 'App\Http\Controllers\mgmt\payment\PaymentController@updatePayment'
    ]);

    //강사비 지급 대상
    Route::match(['get','post'],'mgmt/payreport/list',[
        'as' => 'mgmt.payreport.list',
        'uses' => 'App\Http\Controllers\mgmt\payreport\PayReportController@list'
    ]);

    //강사비 지급 대상
    Route::match(['get','post'],'mgmt/payreport/exportExcel',[
        'as' => 'mgmt.payreport.exportExcel',
        'uses' => 'App\Http\Controllers\mgmt\payreport\PayReportController@exportExcel'
    ]);

    //강사비 정산
    Route::match(['get','post'],'mgmt/paycalculate/list',[
        'as' => 'mgmt.paycalculate.list',
        'uses' => 'App\Http\Controllers\mgmt\paycalculate\PayCalculateController@list'
    ]);

    //강사비 정산처리
    Route::match(['get','post'],'mgmt/paycalculate/createDo',[
        'as' => 'mgmt.paycalculate.createDo',
        'uses' => 'App\Http\Controllers\mgmt\paycalculate\PayCalculateController@createDo'
    ]);

    //강사비 정산 엑셀출력
    Route::match(['get','post'],'mgmt/paycalculate/exportExcel',[
        'as' => 'mgmt.paycalculate.exportExcel',
        'uses' => 'App\Http\Controllers\mgmt\paycalculate\PayCalculateController@exportExcel'
    ]);


    //강의 진행관리 목록
    Route::match(['get','post'],'mgmt/progress/list',[
        'as' => 'mgmt.progress.list',
        'uses' => 'App\Http\Controllers\mgmt\progress\ProgressController@list'
    ]);

    Route::match(['get','post'],'mgmt/progress/exportExcel',[
        'as' => 'mgmt.progress.exportExcel',
        'uses' => 'App\Http\Controllers\mgmt\progress\ProgressController@exportExcel'
    ]);


});




//관리자 + 메니저 권한 메뉴
Route::middleware(['managermiddle'])->group(function(){

    //강좌 배정 목록
    Route::match(['get','post'],'grade/lecture/list',[
        'as' => 'grade.lecture.list',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@list'
    ]);


    //강좌 배정 상세
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


    //클래스 강사 매핑 상태 업데이트
    Route::match(['get','post'],'grade/lecture/updateStatus',[
        'as' => 'grade.lecture.updateStatus',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@updateStatus'
    ]);


    //사용자 목록 팝업
    Route::match(['get','post'],'grade/lecture/popupUserMulti',[
        'as' => 'grade.lecture.popupUserMulti',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@popupUserMulti'
    ]);


    //사용자 매칭 업데이트
    Route::match(['get','post'],'grade/lecture/updateUserMulti',[
        'as' => 'grade.lecture.updateUserMulti',
        'uses' => 'App\Http\Controllers\grade\lecture\LectureController@updateUserMulti'
    ]);


});



//로그인 유저 권한 메뉴
Route::middleware(['auth'])->group(function(){


    //파일다운
    Route::match(['get','post'],'common/file/fileDown',[
        'as' => 'common.file.fileDown',
        'uses' => 'App\Http\Controllers\common\file\FileUtilController@fileDown'
    ]);



    //개인정보 수정화면
    Route::match(['get','post'],'auth/myinfo/update',[
        'as' => 'auth.myinfo.update',
        'uses' => 'App\Http\Controllers\users\UsersController@update'
    ]);

    //개인정보 수정
    Route::match(['get','post'],'auth/myinfo/updateDo',[
        'as' => 'auth.myinfo.updateDo',
        'uses' => 'App\Http\Controllers\users\UsersController@updateDo'
    ]);


    //비밀번호 수정화면
    Route::match(['get','post'],'auth/myinfo/passwd',[
        'as' => 'auth.myinfo.passwd',
        'uses' => 'App\Http\Controllers\users\UsersController@passwd'
    ]);

    //비밀번호 수정
    Route::match(['get','post'],'auth/myinfo/passwdDo',[
        'as' => 'auth.myinfo.passwdDo',
        'uses' => 'App\Http\Controllers\users\UsersController@passwdDo'
    ]);


    //오픈 강좌  목록
    Route::match(['get','post'],'grade/openlecture/list',[
        'as' => 'grade.openlecture.list',
        'uses' => 'App\Http\Controllers\grade\openlecture\OpenLectureController@list'
    ]);



    //내 강좌 배정 목록
    Route::match(['get','post'],'grade/mylecture/list',[
        'as' => 'grade.mylecture.list',
        'uses' => 'App\Http\Controllers\grade\mylecture\MyLectureController@list'
    ]);

    //내 강좌 상세
    Route::match(['get','post'],'grade/mylecture/read',[
        'as' => 'grade.mylecture.read',
        'uses' => 'App\Http\Controllers\grade\mylecture\MyLectureController@read'
    ]);

    //내 강좌 수정화면
    Route::match(['get','post'],'grade/mylecture/update',[
        'as' => 'grade.mylecture.update',
        'uses' => 'App\Http\Controllers\grade\mylecture\MyLectureController@update'
    ]);

    //내 강좌 수정
    Route::match(['get','post'],'grade/mylecture/updateDo',[
        'as' => 'grade.mylecture.updateDo',
        'uses' => 'App\Http\Controllers\grade\mylecture\MyLectureController@updateDo'
    ]);

    //내 강좌 상태 수정
    Route::match(['get','post'],'grade/mylecture/updateClassStatus',[
        'as' => 'grade.mylecture.updateClassStatus',
        'uses' => 'App\Http\Controllers\grade\mylecture\MyLectureController@updateClassStatus'
    ]);

    //내 강좌 상태 수정
    Route::match(['get','post'],'grade/mylecture/updateClassReset',[
        'as' => 'grade.mylecture.updateClassReset',
        'uses' => 'App\Http\Controllers\grade\mylecture\MyLectureController@updateClassReset'
    ]);



    //내 강좌 지급요청
    Route::match(['get','post'],'grade/mylecture/updatePayment',[
        'as' => 'grade.mylecture.updatePayment',
        'uses' => 'App\Http\Controllers\grade\mylecture\MyLectureController@updatePayment'
    ]);


    //내 강좌 활동일지 목록
    Route::match(['get','post'],'grade/acreport/list',[
        'as' => 'grade.acreport.list',
        'uses' => 'App\Http\Controllers\grade\acreport\AcRepoertController@list'
    ]);


    //내 강좌 활동일지 작성화면
    Route::match(['get','post'],'grade/acreport/create',[
        'as' => 'grade.acreport.create',
        'uses' => 'App\Http\Controllers\grade\acreport\AcRepoertController@create'
    ]);


    //내 강좌 활동일지 작성
    Route::match(['get','post'],'grade/acreport/createDo',[
        'as' => 'grade.acreport.createDo',
        'uses' => 'App\Http\Controllers\grade\acreport\AcRepoertController@createDo'
    ]);


    //내 강좌 활동일지 상세
    Route::match(['get','post'],'grade/acreport/read',[
        'as' => 'grade.acreport.read',
        'uses' => 'App\Http\Controllers\grade\acreport\AcRepoertController@read'
    ]);


    //내 강좌 활동일지 수정화면
    Route::match(['get','post'],'grade/acreport/update',[
        'as' => 'grade.acreport.update',
        'uses' => 'App\Http\Controllers\grade\acreport\AcRepoertController@update'
    ]);


    //내 강좌 활동일지 수정
    Route::match(['get','post'],'grade/acreport/updateDo',[
        'as' => 'grade.acreport.updateDo',
        'uses' => 'App\Http\Controllers\grade\acreport\AcRepoertController@updateDo'
    ]);

    //지급요청 관리
    Route::match(['get','post'],'grade/payment/list',[
        'as' => 'grade.payment.list',
        'uses' => 'App\Http\Controllers\grade\payment\PaymentController@list'
    ]);


    //강사비조회
    Route::match(['get','post'],'grade/paycalculate/list',[
        'as' => 'grade.paycalculate.list',
        'uses' => 'App\Http\Controllers\grade\paycalculate\PayCalculateController@list'
    ]);

    //강사비조회 엑셀다운
    Route::match(['get','post'],'grade/paycalculate/exportExcel',[
        'as' => 'grade.paycalculate.exportExcel',
        'uses' => 'App\Http\Controllers\grade\paycalculate\PayCalculateController@exportExcel'
    ]);

    //강사비 지급조서 출력
    Route::match(['get','post'],'grade/paycalculate/popupPayDocument',[
        'as' => 'grade.paycalculate.popupPayDocument',
        'uses' => 'App\Http\Controllers\grade\paycalculate\PayCalculateController@popupPayDocument'
    ]);




    //게시판 목록
    Route::match(['get','post'], 'common/board/list',[
        'as' => 'common.board.list',
        'uses' => 'App\Http\Controllers\common\board\BoardController@list'
    ]);


    //게시판 등록 화면
    Route::match(['get','post'], 'common/board/create',[
        'as' => 'common.board.create',
        'uses' => 'App\Http\Controllers\common\board\BoardController@create'
    ]);

    //게시판 등록 화면
    Route::match(['get','post'], 'common/board/createDo',[
        'as' => 'common.board.createDo',
        'uses' => 'App\Http\Controllers\common\board\BoardController@createDo'
    ]);

    //게시판 상세 화면
    Route::match(['get','post'], 'common/board/read',[
        'as' => 'common.board.read',
        'uses' => 'App\Http\Controllers\common\board\BoardController@read'
    ]);

    //게시판 수정화면
    Route::match(['get','post'], 'common/board/update',[
        'as' => 'common.board.update',
        'uses' => 'App\Http\Controllers\common\board\BoardController@update'
    ]);

    //게시판 수정
    Route::match(['get','post'], 'common/board/updateDo',[
        'as' => 'common.board.updateDo',
        'uses' => 'App\Http\Controllers\common\board\BoardController@updateDo'
    ]);

    //게시판 삭제
    Route::match(['get','post'], 'common/board/delete',[
        'as' => 'common.board.delete',
        'uses' => 'App\Http\Controllers\common\board\BoardController@delete'
    ]);




});




Route::match(['get','post'],'/test/main', 'App\Http\Controllers\test\MainController@main');

Route::get('/test/hello', 'App\Http\Controllers\test\MainController@hello');

Route::get('/test/bye', 'App\Http\Controllers\test\MainController@bye');

Route::get('/test/frame', 'App\Http\Controllers\test\MainController@frame');

Route::get('/test/project', 'App\Http\Controllers\test\MainController@project');

Route::get('/test/file', 'App\Http\Controllers\test\MainController@file');
Route::post('/test/fileDo', 'App\Http\Controllers\test\MainController@fileDo');

