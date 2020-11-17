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
     //   $member_count = User::with('classCategories')->where('grade',0)->count();
     //   dd($member_count);

         $member2 = User::with('classCategories:class_gubun,class_name')
                         ->select('id', 'group', 'name', 'email', 'grade','gubun','status','created_at')
                         ->where('grade', 0)
                         ->orderBy('created_at', 'desc')
                         ->paginate(11);
        // ->get();
        //dd($member);

        //$cate = ClassCategory::get();

//dd(DB::getQueryLog());
        $count = DB::select('select count(a.id) as count
                                    from users a
                                    inner join class_category_user b ON a.id=b.user_id
                                    inner join class_categories c ON b.class_category_id=c.id
                                    where  grade = ?', [0]);
//echo $count[0]->count;

        $member = DB::select('select a.id
                                     , a.name
                                     , a.email
                                     , a.group
                                     , a.grade
                                     , case when a.grade =0 then "대기"
                                            when a.grade =1 then "승인"
                                            end as grade_value
                                     , a.gubun
                                     , case when a.gubun =0 then "내부"
                                            when a.gubun =1 then "외부"
                                            end as gubun_value
                                     , a.status
                                     , a.created_at
                                     , c.class_gubun
                                     , c.class_name
                                from users a
                                inner join class_category_user b ON a.id=b.user_id
                                inner join class_categories c ON b.class_category_id=c.id
                                where  grade = ?
                                order by a.created_at', [0]);



        // dd($r_member);
        return view('member.list', ['userlist'=>$member2, 'count'=>$count[0]->count]);
    }

}
