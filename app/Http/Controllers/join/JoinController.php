<?php

namespace App\Http\Controllers\join;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClassCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    //가입 폼
    public function getRegister(){
        $items = ClassCategory::get(['id', 'class_name']);
        //$items = array( 'code1'=>'value1','code2'=>'value2');
        return view('join.register', ['items'=>$items]);
    }


    //가입처리
    public function postRegister(Request $request){

        $rule = [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required', 'string', 'min:10','max:13'],
            'birthday' => ['required', 'string'],
            'zipcode' => ['required', 'string', 'min:5','max:5'],
            'address' => ['required', 'string', 'min:5','max:100'],

        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $user = new User;
            $user->fill($request->input());
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $class_category_id = $request->input('class_category_id');

            $user->classCategories()->attach($class_category_id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

        return redirect()->route('auth.login')->with('message', '정상적으로 등록 되었습니다. 관리자 승인후 로그인이 가능합니다.');
    }

}
