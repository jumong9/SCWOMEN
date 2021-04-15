<?php

namespace App\Http\Controllers\grade\lecture;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\ClassLector;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LectureController extends Controller{

    public $pageTitle;

    public function __construct(){
        $this->pageTitle = "강좌배정관리";
    }



    public function list(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        DB::enableQueryLog();
        $user_id = Auth::id();
        //echo Auth::user()->grade;

        $classList = ContractClass::join('contracts', 'contracts.id', '=','contract_classes.contract_id')
                                    ->join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_category_user as c', 'c.class_category_id', '=', 'contract_classes.class_category_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            )
                                    ->where('contracts.status','>',1)
                                    ->where('c.user_id', $user_id)
                                    ->where('c.user_grade',10)
                                    ->where('b.name','LIKE',"{$searchWord}%")
                                    ->orderBy('contract_classes.created_at', 'desc')
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


        //dd(DB::getQueryLog());
        return view('grade.lecture.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

    }



    public function read(Request $request){
        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');

        $id = $request->input('id');
        $user_id = Auth::id();

        $classList = ContractClass::join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_category_user as c', 'c.class_category_id', '=', 'contract_classes.class_category_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            )
                                    ->where('contract_classes.id',$id)
                                    ->where('c.user_id', $user_id)
                                    ->where('c.user_grade',10)

                                    ->get();

        $contract = Contracts::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'contracts.status')
                                            ->where('c.code_group', '=','contract_status');
                                    }
                                )->where('contracts.id',$classList[0]->contract_id)
                                ->get();


        $contract[0]->id=$id;

        $client = Client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                     ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $classList[0]->client_id)
                            ->get();

        // $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
        //                 ->where('contract_class_id',$id)
        //                 ->orderBy('main_yn','desc')
        //                 ->get();
        $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
                        ->join('contract_classes as d', 'd.id', '=', 'class_lectors.contract_class_id')
                        ->join('class_category_user as c', function($join){
                              $join->on('c.user_id', '=', 'class_lectors.user_id');
                              $join->on('c.class_category_id' ,'=', 'class_lectors.class_category_id');
                              }
                        )
                        ->where('contract_class_id',$id)
                        ->orderBy('main_yn','desc')
                        ->get();

//dd(DB::getQueryLog());
        return view('grade.lecture.read', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
        //return "ok";
    }


    public function popupUser(Request $request){

        $id = $request->input('id');
        DB::enableQueryLog();
        $userList = User::join('class_category_user as b', 'b.user_id', '=', 'users.id')
                            ->join('contract_classes as c', 'c.class_category_id', '=', 'b.class_category_id')
                            ->select('users.id as user_id',
                                     'users.name as user_name',
                                     'b.user_status as user_status',
                                     'b.user_group as group',
                                     'b.main_count',
                                     'b.sub_count',
                                     'c.id as class_id',
                                     'c.main_count as class_main_count',
                                     'c.sub_count as class_sub_count',
                                     'c.class_category_id')
                            ->whereIn('b.user_status', [2,4])
                            ->where('c.id' , $id)
                            ->orderBy('b.user_group', 'desc')
                            ->orderBy('b.user_status', 'asc')
                            ->get();


        if(sizeof($userList) ==0){
            throw new Exception('강사 정보가 존재하지 않습니다.');
        }

        $cateId = $userList[0]->class_category_id;

        $classItems = ClassCategory::orderBy('class_group', 'asc', 'class_order', 'asc')->get(['id', 'class_name']);



        $selectedUser = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
                                   ->join('class_category_user as c', function($join){
                                            $join->on('c.user_id', '=', 'class_lectors.user_id');
                                            $join->on('c.class_category_id' ,'=', 'class_lectors.class_category_id');
                                            }
                                    )
                                    ->select('class_lectors.*',
                                             'b.id as user_id',
                                             'b.name as user_name',
                                             'c.user_status as user_status',
                                             'c.user_group as group',
                                             'c.main_count',
                                             'c.sub_count',
                                             'c.id as class_id',
                                             'c.main_count as class_main_count',
                                             )
                                    ->where('contract_class_id',$id)
                                    ->get();
        //dd(DB::getQueryLog());
        return view('grade.lecture.popupuser', ['class_id'=>$id, 'cateId'=>$cateId, 'selectedUser'=>$selectedUser, 'userList'=>$userList, 'classItems'=> $classItems ]);

    }


    public function popupUserMulti(Request $request){

        $contract_class_id = $request->input('contract_class_id');
        $id = $request->input('class_category_id');

        DB::enableQueryLog();
        $userList = User::join('class_category_user as b', 'b.user_id', '=', 'users.id')
                            ->select('users.id as user_id',
                                     'users.name as user_name',
                                     'b.user_status as user_status',
                                     'b.user_group as group',
                                     'b.main_count',
                                     'b.sub_count')
                            ->whereIn('b.user_status', [2,4])
                            ->where('b.class_category_id' , $id)
                            ->orderBy('b.user_group', 'desc')
                            ->orderBy('b.user_status', 'asc')
                            ->get();

        //dd(DB::getQueryLog());
        //return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

        // $selectedUser = ClassLector::where('contract_class_id',$id)
        //                             ->get();
        // dd(DB::getQueryLog());
        return view('grade.lecture.popupusermulti', ['class_id'=>$id, 'contract_class_id'=>$contract_class_id, 'userList'=>$userList]);
    }


    public function updateUser(Request $request){
        DB::enableQueryLog();
        $main_user_id = $request->input('main_user_id');
        $sub_user_id = $request->input('sub_user_id');
        $contract_class_id = $request->input('contract_class_id');

        try {
            DB::beginTransaction();

            ClassLector::where('contract_class_id',$contract_class_id)
                        ->delete();

            $mainUser = new ClassLector();
            $mainUser->contract_class_id = $contract_class_id;
            $mainUser->main_yn = 1;
            $main_user_data = explode("_", $main_user_id);
            $mainUser->user_id = $main_user_data[0];
            $mainUser->class_category_id = $main_user_data[1];

            $mainUser->save();

            if(!empty($sub_user_id)){
                foreach($sub_user_id as $sub){
                    $sub_user_data = explode("_", $sub);
                    $subUser = new ClassLector();
                    $subUser->contract_class_id = $contract_class_id;
                    $subUser->main_yn = 0;
                    $subUser->user_id = $sub_user_data[0];
                    $subUser->class_category_id = $sub_user_data[1];
                    $subUser->save();
                }
            }
            //dd(DB::getQueryLog());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }


    public function updateUserMulti(Request $request){

        $main_user_id = $request->input('main_user_id');
        $sub_user_id = $request->input('sub_user_id');
        $contract_class_id = $request->input('contract_class_id');

        try {
            DB::beginTransaction();

            $list_class = explode(",", $contract_class_id);
            foreach($list_class as $class_id){

                ClassLector::where('contract_class_id',$class_id)
                            ->delete();

                $mainUser = new ClassLector();
                $mainUser->contract_class_id = $class_id;
                $mainUser->main_yn = 1;
                $mainUser->user_id = $main_user_id;
                $mainUser->save();

                if(!empty($sub_user_id)){
                    foreach($sub_user_id as $sub){
                        $subUser = new ClassLector();
                        $subUser->contract_class_id = $class_id;
                        $subUser->main_yn = 0;
                        $subUser->user_id = $sub;
                        $subUser->save();
                    }
                }

                ContractClass::where('id',$class_id)
                        ->update([
                            'lector_apply_yn'=>'1'
                        ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }



    public function updateStatus(Request $request){


        $id = $request->input('id');

        ContractClass::where('id',$id)
                    ->update([
                        'lector_apply_yn'=>'1'
                    ]);

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }


    public function allUserList(Request $request){

        $class_category_id = $request->input('class_category_id');
        DB::enableQueryLog();
        $userList = User::join('class_category_user as b', 'b.user_id', '=', 'users.id')
                            ->select('users.id as user_id',
                                     'users.name as user_name',
                                     'b.class_category_id',
                                     'b.user_status as user_status',
                                     'b.user_group as group',
                                     'b.main_count',
                                     'b.sub_count')
                            ->whereIn('b.user_status', [2,4])
                            ->where('b.class_category_id' , $class_category_id)
                            ->orderBy('b.user_group', 'desc')
                            ->orderBy('b.user_status', 'asc')
                            ->get();

        //dd(DB::getQueryLog());

        return response()->json(['userList' => $userList]);
    }
}
