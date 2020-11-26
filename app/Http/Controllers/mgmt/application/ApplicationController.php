<?php

namespace App\Http\Controllers\mgmt\application;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\ClassCategoryUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller{

    /**
     * 사용자 목록
     */
    public function list(Request $request){

        DB::enableQueryLog();

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = (null==$request->input('searchStatus') ) ? 0 : $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');


        $member = User::join('class_category_user', 'users.id' ,'=', 'class_category_user.user_id')
                        ->join('class_categories', 'class_category_user.class_category_id', '=', 'class_categories.id')
                        ->select('users.id', 'users.group', 'users.name', 'users.mobile'
                                , 'users.email', 'users.grade','users.gubun','users.status','users.created_at'
                                , 'class_categories.class_name', 'class_category_user.main_count', 'class_category_user.sub_count')
                        ->where('users.grade', '<', 90)
                        ->where('users.status', 0)
                        ->where(function($query) use ($request){
                            $searchType = $request->input('searchType');
                            $searchWord = $request->input('searchWord');
                            $searchStatus = (null==$request->input('searchStatus') ) ? 99 : $request->input('searchStatus');


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
        return view('mgmt.application.list', ['userlist'=>$member, 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]);

    }


     /**
     * 사용자 정보 상세화면
     */
    public function read(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');


        $id = $request->input('id');
        $member = User::with('classCategories:class_gubun,class_name')->where('id', $id)->get();
        $classCategory = ClassCategoryUser::join('class_categories', 'class_category_user.class_category_id', '=', 'class_categories.id')->where('user_id', $id)->get();


        return view('mgmt.application.read', ['member'=>$member, 'classCategory' => $classCategory, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]);
    }


     /**
     * 사용자 정보 수정화면
     */
    public function update(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');


        $id = $request->input('id');
        $member = User::with('classCategories')->where('id', $id)->get();
        $classCategory = ClassCategoryUser::join('class_categories', 'class_category_user.class_category_id', '=', 'class_categories.id')->where('user_id', $id)->get();

        $classItems = ClassCategory::orderBy('class_group', 'asc', 'class_order', 'asc')->get(['id', 'class_name']);

        return view('mgmt.application.update', ['member'=>$member, 'classCategory' => $classCategory, 'classItems'=>$classItems, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]);
    }



    /**
     * 사용자 정보 업데이트
     */
    public function updateDo(Request $request){

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

        return redirect()->route('mgmt.application.read', ['id' =>$id, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]) ;

    }



    /**
     * 사용자 승인처리
     */
    public function approval(Request $request){
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
    public function delete(Request $request){
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
