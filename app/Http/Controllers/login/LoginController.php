<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;


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
            return back()->withInput()->with('message','이메일주소나 패스워드가 틀립니다.');
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

    //아이디 찾기폼
    public function getFindid(){
        return view('/login/findid');
    }

    //아이디 찾기
    public function findidDo(Request $request){

        try {
            DB::enableQueryLog();
           
            $name = $request->input('name');
            $mobile = $request->input('mobile');


            $user_email = User::where('name', $name)
                                ->where('mobile', $mobile)
                                ->select('email')
                                ->first();
            
            //dd(DB::getQueryLog());
            if(empty($user_email)){
                return back()->withInput()->with('message','사용자가 존재하지 않습니다.');

            }else{
                return back()->withInput()->with('message',"로그인 아이디는 ". $user_email->email ." 입니다.");

            }
        } catch (Exception $e) {
            return back()->withInput()->with('message','사용자가 존재하지 않습니다.');
        }

    }


}
