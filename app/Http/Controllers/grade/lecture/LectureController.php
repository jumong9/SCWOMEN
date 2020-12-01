<?php

namespace App\Http\Controllers\grade\lecture;

use App\Http\Controllers\Controller;
use App\Models\ClassLector;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use App\Models\User;
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

        $classList = ContractClass::join('contracts', 'contracts.id', '=','contract_classes.contract_id')
                                    ->join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_category_user as c', 'c.class_category_id', '=', 'contract_classes.class_category_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            )
                                    ->where('contracts.status',2)
                                    ->where('c.user_id', $user_id)
                                    ->where('c.user_grade',10)
                                    ->paginate($perPage);

        $contractList = Contracts::join('common_codes as c', function($join){
                                            $join->on('c.code_id','=', 'contracts.status')
                                                ->where('c.code_group', '=','contract_status');
                                            }
                                    )
                                    ->join('clients as cl', function($join){
                                            $join->on('cl.id','=', 'contracts.client_id');
                                            }
                                    )
                                    ->select('contracts.*', 'c.code_value', 'cl.name as client_name', 'cl.gubun')
                                    ->where('cl.name','LIKE',"{$searchWord}%")
                                    ->orderBy('contracts.created_at', 'desc')
                                    ->paginate($perPage);
        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


 //       dd(DB::getQueryLog());
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
                            ->where('clients.id', $contract[0]->client_id)
                            ->get();

        $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
                        ->where('conatract_class_id',$id)
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
                                     'users.status as user_status',
                                     'users.group as group',
                                     'b.main_count',
                                     'b.sub_count',
                                     'c.id as class_id')
                            ->whereIn('users.status', [2,4])
                            ->where('c.id' , $id)
                            ->orderBy('users.group', 'desc')
                            ->orderBy('users.status', 'asc')
                            ->get();

        //dd(DB::getQueryLog());
        //return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

        $selectedUser = ClassLector::where('conatract_class_id',$id)
                                    ->get();
        // dd(DB::getQueryLog());
        return view('grade.lecture.popupuser', ['class_id'=>$id, 'selectedUser'=>$selectedUser, 'userList'=>$userList]);
    }


    public function updateUser(Request $request){

        $main_user_id = $request->input('main_user_id');
        $sub_user_id = $request->input('sub_user_id');
        $conatract_class_id = $request->input('conatract_class_id');

        ClassLector::where('conatract_class_id',$conatract_class_id)
                    ->delete();

        $mainUser = new ClassLector();
        $mainUser->conatract_class_id = $conatract_class_id;
        $mainUser->main_yn = 1;
        $mainUser->user_id = $main_user_id;

        $mainUser->save();

        if(!empty($sub_user_id)){
            foreach($sub_user_id as $sub){
                $subUser = new ClassLector();
                $subUser->conatract_class_id = $conatract_class_id;
                $subUser->main_yn = 0;
                $subUser->user_id = $sub;
                $subUser->save();
            }
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


}
