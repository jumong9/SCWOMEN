<?php

namespace App\Http\Controllers\grade\mylecture;

use App\Http\Controllers\Controller;
use App\Models\ClassLector;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyLectureController extends Controller{

    public function __construct(){
        $this->pageTitle = "나의 강좌 관리";
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

        $classList = ContractClass::join('class_categories as b', 'b.id' ,'=', 'contract_classes.class_category_id')
                                    ->join('class_lectors as c', 'c.conatract_class_id', '=','contract_classes.id')
                                    ->join('contracts as d', 'd.id', '=', 'contract_classes.contract_id')
                                    ->join('clients as e', 'e.id', '=', 'contract_classes.client_id')
                                    ->select('contract_classes.*'
                                            , 'b.class_name'
                                            , 'c.main_yn'
                                            , 'c.user_id'
                                            , 'e.name as client_name'
                                    )
                                    ->where('d.status', '>', '3')
                                    ->where('c.user_id', $user_id)
                                    ->where('e.name','LIKE',"{$searchWord}%")
                                    ->orderBy('contract_classes.class_day', 'desc')
                                    ->orderBy('contract_classes.created_at', 'desc')
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


        //dd(DB::getQueryLog());
        return view('grade.mylecture.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

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
        return view('grade.mylecture.read', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
        //return "ok";
    }


    public function update(Request $request){
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
        return view('grade.mylecture.update', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
        //return "ok";
    }


    public function updateDo(Request $request){

        $id = $request->input('id');
        $class_status = $request->input('class_status');
        $class_type = $request->input('class_type');
        $online_type = $request->input('online_type');


        if(!ClassLector::where('conatract_class_id',$id)
                        ->where('user_id',  Auth::id())
                        ->first()){
            return response()->json(['msg'=>'잘못된 접근입니다.']);
        }


        ContractClass::where('id',$id)
                        ->update([
                            'class_status'=> $class_status,
                            'class_type'=> $class_type,
                            'online_type'=> $online_type,
                        ]);

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }


    public function updateClassStatus(Request $request){


        $id = $request->input('id');
        $class_status = $request->input('class_status');

        ContractClass::where('id',$id)
                        ->update([
                            'class_status'=>$class_status
                        ]);

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }

}
