<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller{

    //로그인폼
    public function getLogin(){
        if(Auth::check()){
            return redirect()->route('common.board.list');
        }
        return view('/login/login');
    }

    //로그인
    public function postLogin(Request $request){

        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (! Auth::attempt($credentials)) {
            return back()->withInput();
        }

        //미승인 사용자 로그아웃 처리
        if(0 == Auth::user()->status){
            Auth::logout();
            return redirect('/')->with('message', '승인 처리중 입니다. 관리자 승인후 로그인이 가능합니다.');
        }

        //관리자 메인페이지
        if(90 <= Auth::user()->grade){
            return redirect()->route('common.board.list');
        }else{
            return redirect()->route('common.board.list');
        }

    }

    //로그아웃
    public function getLogout(){
        Auth::logout();
        return redirect('/');
    }

    //로그아웃
    public function postLogout(){
        Auth::logout();
        return redirect('/');
    }

}
