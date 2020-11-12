<?php

namespace App\Http\Controllers\join;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JoinController extends Controller{

    public function __construct(){
        $this->middleware('guest');
    }


    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    //가입처리
    public function create(Request $request){

        $rule = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required', 'string', 'min:10','max:13'],
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->fill($request->input());
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $class_category_id = $request->input('class_category_id');

        $user->classCategories()->attach($class_category_id);

        return redirect()->route('auth.create');
    }

}
