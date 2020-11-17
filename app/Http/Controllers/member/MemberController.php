<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller{

    public function list(Request $request){

        //DB::enableQueryLog();

        //$mem = User::
        $member_count = User::where('grade',0)->count();


        $member = User::with('classCategories:class_gubun,class_name')
        ->select('id', 'group', 'name', 'email', 'grade','gubun','status')
        ->where('grade', 99)
        ->orderBy('created_at', 'desc')
        ->get();
        //dd($member);

        $cate = ClassCategory::get();


        $r_member = DB::select('select a.id, a.name, a.email, a.group, a.grade, a.gubun, a.status, c.class_gubun, c.class_name
                                from users a
                                INNER JOIN class_category_user b ON a.id=b.user_id
                                INNER JOIN class_categories c ON b.class_category_id=c.id
                                where  grade = ?', [0]);

        //dd(DB::getQueryLog());

        // dd($r_member);
        return view('member.list', ['userlist'=>$member, 'ruserlist'=>$r_member, 'count'=>$member_count, 'cate'=>$cate]);
    }

}
