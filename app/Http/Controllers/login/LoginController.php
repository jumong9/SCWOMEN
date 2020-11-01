<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller{

    public function loginForm(){
        return view('/login/loginform');
    }

    public function login(Request $request){

        $id = $request->input('id');
        $password = $request->input('password');
        Log::debug('Showing user profile for user: '.$id);
        Log::info('Showing user profile for user: '.$password);
        return view('test.hello')->with(['id'=> $id, 'password'=>$password]);
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
