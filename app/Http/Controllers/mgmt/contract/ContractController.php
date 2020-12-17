<?php

namespace App\Http\Controllers\mgmt\contract;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\ClassLector;
use App\Models\Client;
use App\Models\CommonCode;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller{
    //
    public $pageTitle;

    public function __construct(){
        $this->pageTitle = "계약관리";
    }

    public function create(Request $request){

        $id = $request->input('id');
        $client = new Client();
        $result = $client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                    ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $id)->get();


        $codelist = CommonCode::getCommonCode('contract_status');
        $classItems = ClassCategory::orderBy('class_group', 'asc', 'class_order', 'asc')->get(['id', 'class_name']);

        $result[0]->id = $id;
        return view('mgmt.contract.create', ['pageTitle'=>$this->pageTitle, 'client'=>$result[0], 'commonCode'=> $codelist, 'classItems'=> $classItems ]);
    }


    public function createDo(Request $request){

        $classTargetList = $request->get('classTargetList');
        $classJson = json_decode($classTargetList, true);
        $client_id = $request->input('client_id');

        $client_info = Client::where('id', $client_id)->first();

        $contrats_arr = [
            "client_id"           =>  $client_id,
            "client_name"         =>  $client_info->name,
            "name"                =>  $request->input('name'),
            "email"               =>  $request->input('email'),
            "phone"               =>  $request->input('phone'),
            "phone2"              =>  $request->input('phone2'),
            "class_cost"          =>  $request->input('class_cost'),
            "class_total_cost"    =>  $request->input('class_total_cost'),
            "material_cost"       =>  $request->input('material_cost'),
            "material_total_cost" =>  $request->input('material_total_cost'),
            "total_cost"          =>  $request->input('total_cost'),
            "paid_yn"             =>  $request->input('paid_yn'),
            "status"              =>  $request->input('status'),
            "comments"            =>  $request->input('comments'),
        ];

        //contract 정보 생성
        $contract_id = Contracts::create($contrats_arr)->id;


        //contract class 정보 생성
        foreach($classJson as $class){

            $inputClass = new ContractClass();

            $inputClass->contract_id            = $contract_id;
            $inputClass->client_id              = $client_id;
            $inputClass->class_day              = $class['class_day'];
            $inputClass->time_from              = $class['time_from'];
            $inputClass->time_to                = $class['time_to'];
            $inputClass->class_category_id      = $class['class_category_id'];
            $inputClass->class_target           = $class['class_target'];
            $inputClass->class_number           = $class['class_number'];
            $inputClass->class_count            = $class['class_count'];
            $inputClass->class_order            = $class['class_order'];
            $inputClass->main_count             = $class['main_count'];
            $inputClass->sub_count              = $class['sub_count'];
            $inputClass->class_type             = $class['class_type'];
            $inputClass->main_count             = $class['main_count'];

            $inputClass->save();

        }


        return redirect()->route('mgmt.contract.read', ['pageTitle'=>$this->pageTitle,'id' =>$contract_id , 'client_id' =>$client_id ]) ;
    }


    public function read(Request $request){
//DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');
        $id = $request->input('id');

        $contract = Contracts::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'contracts.status')
                                         ->where('c.code_group', '=','contract_status');
                                    }
                                )->where('contracts.id',$id)->get();
        $contract[0]->id=$id;
        $client_id = $contract[0]->client_id;

        $classList = ContractClass::join('class_categories', 'contract_classes.class_category_id', '=', 'class_categories.id')
                                    ->where('contract_id', $id)->get();

        $client = new Client();
        $result = $client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                     ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $client_id)->get();

        $lectorList = ContractClass::join('class_lectors as c', 'contract_classes.id', '=', 'c.contract_class_id')
                                   ->join('users as d', 'c.user_id', '=', 'd.id')
                                   ->join('class_categories as e' , 'e.id' ,'=', 'contract_classes.class_category_id')
                                   ->select('contract_classes.contract_id'
                                            , 'contract_classes.class_day'
                                            , 'contract_classes.time_from'
                                            , 'contract_classes.time_to'
                                            , 'contract_classes.class_target'
                                            , 'e.class_name'
                                            , 'd.name as user_name'
                                            , 'c.main_yn'
                                            , 'c.main_count'
                                            , 'c.sub_count')
                                   ->where('contract_classes.contract_id', $id)
                                   ->orderBy('contract_classes.class_day', 'asc')
                                   ->orderBy('contract_classes.class_category_id', 'asc')
                                   ->orderBy('contract_classes.time_from', 'asc')
                                   ->orderBy('c.main_yn', 'desc')
                                   ->get();

//dd(DB::getQueryLog());
        return view('mgmt.contract.read', ['pageTitle'=>$this->pageTitle,'client'=>$result[0], 'lectorList'=>$lectorList, 'contract'=>$contract[0], 'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
    }


    public function list(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        DB::enableQueryLog();
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
        $contractList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


 //       dd(DB::getQueryLog());
        return view('mgmt.contract.list', ['pageTitle'=>$this->pageTitle,'contractList'=>$contractList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

    }


    public function update(Request $request){
        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');
        $id = $request->input('id');

        $contract = Contracts::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'contracts.status')
                                            ->where('c.code_group', '=','contract_status');
                                    }
                                )->where('contracts.id',$id)->get();
        $contract[0]->id=$id;
 //       dd(DB::getQueryLog());
        $client_id = $contract[0]->client_id;

        $classList = ContractClass::join('class_categories', 'contract_classes.class_category_id', '=', 'class_categories.id')
                                    ->select('contract_classes.*', 'class_categories.class_name' )
                                    ->where('contract_id', $id)->get();

        //dd(DB::getQueryLog());
        $client = new Client();
        $result = $client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                        ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $client_id)->get();
        $codelist = CommonCode::getCommonCode('contract_status');
        $classItems = ClassCategory::orderBy('class_group', 'asc', 'class_order', 'asc')->get(['id', 'class_name']);


        return view('mgmt.contract.update', ['pageTitle'=>$this->pageTitle,'client'=>$result[0], 'contract'=>$contract[0], 'classList'=>$classList, 'commonCode'=> $codelist, 'classItems'=> $classItems, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
    }



    public function updateDo(Request $request, Contracts $contract){
        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');

        $id = $request->input('id');
        $client_id = $request->input('client_id');

        $classTargetList = $request->get('classTargetList');
        $classJson = json_decode($classTargetList, true);

        $contract->fill($request->input());

        $contract->where('id', $id)
                 ->update([
                    'client_id'                 =>  $contract->client_id,
                    'name'                      =>  $contract->name,
                    'email'                     =>  $contract->email,
                    'phone'                     =>  $contract->phone,
                    'phone2'                    =>  $contract->phone2,
                    'class_cost'                =>  $contract->class_cost,
                    'class_total_cost'          =>  $contract->class_total_cost,
                    'material_cost'             =>  $contract->material_cost,
                    'material_total_cost'       =>  $contract->material_total_cost,
                    'total_cost'                =>  $contract->total_cost,
                    'paid_yn'                   =>  $contract->paid_yn,
                    'status'                    =>  $contract->status,
                    'comments'                  =>  $contract->comments,
                ]);

        //contract class 정보 생성
        foreach($classJson as $class){

            $inputClass = new ContractClass();

            $inputClass->contract_id            = $id;
            $inputClass->client_id              = $client_id;
            $inputClass->class_day              = $class['class_day'];
            $inputClass->time_from              = $class['time_from'];
            $inputClass->time_to                = $class['time_to'];
            $inputClass->class_category_id      = $class['class_category_id'];
            $inputClass->class_target           = $class['class_target'];
            $inputClass->class_number           = $class['class_number'];
            $inputClass->class_count            = $class['class_count'];
            $inputClass->class_order            = $class['class_order'];
            $inputClass->main_count             = $class['main_count'];
            $inputClass->sub_count              = $class['sub_count'];
            $inputClass->class_type             = $class['class_type'];
            $inputClass->main_count             = $class['main_count'];
            if('I' == $class['action_type']){
                $inputClass->save();
            }else if('D' == $class['action_type']){
                $inputClass->id                 = $class['class_id'];
                $inputClass->where('id', $inputClass->id )
                           ->delete();
            }

        }
  //      dd(DB::getQueryLog());

        return redirect()->route('mgmt.contract.read', ['id' =>$id , 'client_id' =>$client_id, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]) ;
    }



    public function updateContractStatus(Request $request){


        $contract_id = $request->input('contract_id');
        $status_code = $request->input('status_code');

        Contracts::where('id',$contract_id)
                   ->update([
                        'status'=> $status_code
                    ]);

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }

}
