<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function main(){
        $books = ['Jacson', 'Laravel'];
        return view('users.main')->with([ 'books'=> $books ]);

    }

    public function update(){
        $user = Auth::user();
        return view('users.update', ['userInfo'=>$user]);
    }

    public function updateDo(Request $request){


        $user_id = Auth::user()->id;

        $user = new User();
        $user->where('id', $user_id)
                ->update([
                    'mobile' => $request->input('mobile'),
                    'zipcode' => $request->input('zipcode'),
                    'address' => $request->input('address'),
                    'birthday' => $request->input('birthday'),
                    ]);

        //return redirect()->route('auth.myinfo.update');
        return redirect()->back()->with('success', '정상적으로 처리 되었습니다.');
    }



    public function passwd(){
        return view('users.passwd');
    }

    public function passwdDo(Request $request){

        $rule = [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::user()->id;

        $user = new User();
        $user->where('id', $user_id)
                ->update([
                    'password' => Hash::make($request->input('password'))
                    ]);

        //return redirect()->route('auth.myinfo.update');
        return redirect()->back()->with('success', '정상적으로 처리 되었습니다.');
    }


}


