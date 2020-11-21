<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\ClassCategoryUser;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MemberController extends Controller{

    public function index(Request $request){
//DB::enableQueryLog();
//dd(DB::getQueryLog());
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

    /**
     * 사용자 목록
     */
    public function list(Request $request){

        DB::enableQueryLog();

        //$mem = User::
     //   $member_count = User::with('classCategories')->where('grade',0)->count();
     //   dd($member_count);
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = (null==$request->input('searchStatus') ) ? 99 : $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');

        //echo $searchStatus;

        // if($searchStatus == 99){
        //     $member2 = User::with('classCategories:class_gubun,class_name')
        //                     ->select('id', 'group', 'name', 'mobile', 'email', 'grade','gubun','status','created_at')
        //                     ->where('grade', '<', 90)
        //                     ->where('name','LIKE',"{$searchWord}%")
        //                     ->orderBy('created_at', 'desc')
        //                     ->paginate($perPage);
        // }else {

            // $member2 = User::with('classCategories:class_gubun,class_name')
            //                 ->select('id', 'group', 'name', 'mobile', 'email', 'grade','gubun','status','created_at')
            //                 ->where('grade', '<', 90)
            //                 ->where('status', "{$searchStatus}")
            //                 ->where('name','LIKE',"{$searchWord}%")
            //                 ->orderBy('created_at', 'desc')
            //                 ->paginate($perPage);
        //}


        $member = User::join('class_category_user', 'users.id' ,'=', 'class_category_user.user_id')
                        ->join('class_categories', 'class_category_user.class_category_id', '=', 'class_categories.id')
                        ->select('users.id', 'users.group', 'users.name', 'users.mobile'
                                , 'users.email', 'users.grade','users.gubun','users.status','users.created_at'
                                , 'class_categories.class_name', 'class_category_user.main_count', 'class_category_user.sub_count')
                        ->where('users.grade', '<', 90)
                        ->where(function($query) use ($request){
                            $searchType = $request->input('searchType');
                            $searchWord = $request->input('searchWord');
                            $searchStatus = (null==$request->input('searchStatus') ) ? 99 : $request->input('searchStatus');

                            if($searchStatus!=99){
                                $query ->where('users.status', "{$searchStatus}");
                            }

                            if(!empty($request->input('searchWord'))){
                                if('name'==$searchType) {
                                    $query ->where('users.name','LIKE',"{$searchWord}%");
                                }elseif('group'==$searchType){
                                    $query ->where('users.group', "{$searchWord}");
                                }
                            }

                        })
                        ->orderBy('users.created_at', 'desc')
                        ->paginate($perPage);


     //   dd(DB::getQueryLog());

        $member->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));
        return view('member.list', ['userlist'=>$member, 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]);

    }



    /**
     * 사용자 정보 상세화면
     */
    public function detail(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');


        $id = $request->input('id');
        $member = User::with('classCategories:class_gubun,class_name')->where('id', $id)->get();
        $classCategory = ClassCategoryUser::join('class_categories', 'class_category_user.class_category_id', '=', 'class_categories.id')->where('user_id', $id)->get();


        return view('member.detail', ['member'=>$member, 'classCategory' => $classCategory, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]);
    }


    /**
     * 사용자 정보 수정화면
     */
    public function modify(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');


        $id = $request->input('id');
        $member = User::with('classCategories')->where('id', $id)->get();
        $classCategory = ClassCategoryUser::join('class_categories', 'class_category_user.class_category_id', '=', 'class_categories.id')->where('user_id', $id)->get();

        $classItems = ClassCategory::orderBy('class_group', 'asc', 'class_order', 'asc')->get(['id', 'class_name']);

        return view('member.modify', ['member'=>$member, 'classCategory' => $classCategory, 'classItems'=>$classItems, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]);
    }


    /**
     * 사용자 정보 업데이트
     */
    public function update(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');


        $user = new User;

        $id = $request->input('id');
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        $gubun = $request->input('gubun');
        $status = $request->input('status');
        $group = $request->input('group');
        $birthday = $request->input('birthday');
        $address = $request->input('address');
        $joinday = $request->input('joinday');
        $stopday = $request->input('stopday');

        $user->fill($request->input());
//DB::enableQueryLog();
        $user->where('id', $id)
             ->update([
                        'name' => $name,
                        'email' => $email,
                        'mobile' => $mobile,
                        'gubun' =>  $gubun,
                        'status' => $status,
                        'group' => $group,
                        'address' => $address,
                        'birthday' => $birthday,
                        'joinday' => $joinday,
                        'stopday' => $stopday
                        ]);

        //기존 클래스 조회
        $oldClassCategory = ClassCategoryUser::where('user_id', $id)->get();

        //기존 클래스 정보 삭제
        ClassCategoryUser::where('user_id',$id)->delete();

        //신규 클래스 등록
        $classCategory = $request->input('class_category_id');
        foreach($classCategory as $cate){
            $classUser = new ClassCategoryUser();
            $classUser->user_id = $id;
            $classUser->class_category_id = $cate;

            $classUser->save();

        }

        //기존 클래스 존재시 업데이트(주,보조강사 횟수)
        foreach($oldClassCategory as $cate){
            $cate->where('user_id', $cate->user_id)
                 ->where('class_category_id', $cate->class_category_id)
                 ->update([
                            'main_count' => $cate->main_count,
                            'sub_count' =>  $cate->sub_count
                        ]);
        }
        //dd(DB::getQueryLog());

        return redirect()->route('member.detail', ['id' =>$id, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]);

        //return redirect()->route('member.detail',['id' =>$id])->with(['perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]);

        //return Redirect::route('member.detail',['id' =>$id, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page ]);
    }



    /**
     * 사용자 승인처리
     */
    public function updateApproval(Request $request){
       // DB::enableQueryLog();
        $ids = $request->input('checkedItemId');
        $items = explode(',',$ids);

        $user = new User;
        foreach($items  as $id){
             $user->where('id', $id)
                  ->update([
                        'status' => 2,
                        'joinday' => date('Y-m-d')
                        ]);
        }
     //   dd(DB::getQueryLog());
        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);
    }


    /**
     * 사용자 삭제처리
     */
    public function deleteUser(Request $request){
         $ids = $request->input('checkedItemId');
         $items = explode(',',$ids);

         $user = new User;
         foreach($items  as $id){
            ClassCategoryUser::where('user_id',$id)->delete();
            User::where('id', $id)->delete();
         }
         return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);
     }


}
