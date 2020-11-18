<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller{

    public function index(Request $request){

        return view('member.list_datatable');
    }

    //sbadmin2 적용 리스트
    public function listbak(Request $request){


        $columns = array(
            0 =>'id',
            1 =>'name',
            2=> 'email',
            3=> 'created_at',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $totalData = User::where('grade',0)->count();

        $totalFiltered = $totalData;


        if(empty($request->input('search.value'))){

            $member = User::with('classCategories:class_gubun,class_name')
                            ->select('id', 'group', 'name', 'email', 'grade','gubun','status','created_at')
                            ->where('grade', 0)
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->get();

        }else{

            $search = $request->input('search.value');

            $member =  User::with('classCategories:class_gubun,class_name')
                            ->select('id', 'group', 'name', 'email', 'grade','gubun','status','created_at')
                            ->where('name','LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = User::where('name','LIKE',"%{$search}%")
                             ->orWhere('email', 'LIKE',"%{$search}%")
                             ->count();

        }

        $data = array();
        if(!empty($member)){

            foreach ($member as $post)
            {
                $show =  route('member.list',$post->id);
                $edit =  route('member.list',$post->id);


                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                $nestedData['group'] = $post->group;
                $nestedData['grade'] = $post->grade;
                $nestedData['gubun'] = $post->gubun;
                $nestedData['status'] = $post->status;
                $nestedData['class_gubun'] = $post->classCategories[0]->class_gubun;
                $nestedData['class_name'] = $post->classCategories[0]->class_name;
                $nestedData['created_at'] = date('Y-m-d h:i a',strtotime($post->created_at));

               // $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
               //                           &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;

            }
        }


        $json_data = array(
                        "draw"            => intval($request->input('draw')),
                        "recordsTotal"    => intval($totalData),
                        "recordsFiltered" => intval($totalFiltered),
                        "data"            => $data
                    );

        return json_encode($json_data);

    }

    //부트스트랩 적용
    public function list(Request $request){

//DB::enableQueryLog();

        //$mem = User::
     //   $member_count = User::with('classCategories')->where('grade',0)->count();
     //   dd($member_count);

         $member2 = User::with('classCategories:class_gubun,class_name')
                         ->select('id', 'group', 'name', 'email', 'grade','gubun','status','created_at')
                         ->where('grade', 0)
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);
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
