<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller{

    public function list(Request $request){

        $member = User::get();
        return view('member.list', ['userlist'=>$member]);
    }

}
