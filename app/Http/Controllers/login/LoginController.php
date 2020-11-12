<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller{

    public function getLogin(){
        if(Auth::check()){
            return redirect('home');
        }
        return view('/login/loginform');
    }

    public function postLogin(Request $request){

        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (! Auth::attempt($credentials)) {
            return back()->withInput();
        }

        return redirect('home');

    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('auth.create');
    }





    public function joinForm(){
        return view('/login/joinForm');
    }

    public function join(Request $request){
        $id = $request->input('id');
        $user_name = $request->input('user_name');

        return view('users.main')
                ->with(['id'=> $id, 'user_name'=>$user_name]);
    }

}
