<?php

namespace App\Http\Controllers\mgmt\contract;

use App\Exports\ContractExport;
use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\ClassLector;
use App\Models\Client;
use App\Models\CommonCode;
use App\Models\ContractClass;
use App\Models\Contracts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\grade\mylecture\MyLectureController;


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
        $financeList = CommonCode::getCommonCode('finance_type');
        $classItems = ClassCategory::orderBy('class_group', 'asc', 'class_order', 'asc')->get(['id', 'class_name']);
        $today = date("Y-m-d", time());

        $result[0]->id = $id;
        return view('mgmt.contract.create', ['pageTitle'=>$this->pageTitle, 'client'=>$result[0], 'commonCode'=> $codelist, 'financeList'=> $financeList, 'classItems'=> $classItems, 'today'=>$today ]);
    }


    public function createDo(Request $request){
        DB::enableQueryLog();
        $classTargetList = $request->get('classTargetList');
//dd($classTargetList);
        $classJson = json_decode($classTargetList, true);
        $client_id = $request->input('client_id');

        try {
        //    DB::beginTransaction();

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
                "outcome_material_cost"       =>  $request->input('outcome_material_cost'),
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
                $inputClass->class_sub_name         = $class['class_sub_name'];
                $inputClass->class_target           = $class['class_target'];
                $inputClass->class_number           = $class['class_number'];
                $inputClass->class_count            = $class['class_count'];
                $inputClass->class_order            = $class['class_order'];
                $inputClass->main_count             = $class['main_count'];
                $inputClass->sub_count              = $class['sub_count'];
                $inputClass->finance                = $class['finance'];
                $inputClass->sub_finance            = $class['sub_finance'];
                $inputClass->class_type             = $class['class_type'];
                $inputClass->online_type            = $class['online_type'];
                $inputClass->save();

            }
        //    dd(DB::getQueryLog());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }


        return redirect()->route('mgmt.contract.read', ['pageTitle'=>$this->pageTitle,'id' =>$contract_id , 'client_id' =>$client_id ]) ;
    }


    public function read(Request $request){
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
        $client_id = $contract[0]->client_id;

        $classList = ContractClass::join('class_categories', 'contract_classes.class_category_id', '=', 'class_categories.id')
                                    ->join('common_codes as c1', function($join){
                                        $join->on('c1.code_id','=', 'contract_classes.finance')
                                            ->where('c1.code_group', '=','finance_type');
                                        }
                                    )
                                    ->leftjoin('common_codes as c2', function($join){
                                        $join->on('c2.code_id','=', 'contract_classes.sub_finance')
                                            ->where('c2.code_group', '=','finance_type');
                                        }
                                    )
                                    ->select('contract_classes.*'
                                            , 'class_categories.class_gubun'
                                            , 'class_categories.class_name'
                                            , 'c1.code_value as finance'
                                            , 'c2.code_value as sub_finance'
                                            )
                                    ->where('contract_id', $id)
                                    ->orderBy('contract_classes.class_day', 'asc')
                                    ->orderBy('contract_classes.time_from', 'asc')
                                    ->orderBy('contract_classes.id', 'asc')
                                    ->get();

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
                                            , 'contract_classes.class_sub_name'
                                            , 'contract_classes.online_type'
                                            , 'contract_classes.finance'
                                            , 'contract_classes.sub_finance'
                                            , 'contract_classes.id'
                                            , 'e.class_name'
                                            , 'd.name as user_name'
                                            , 'c.main_yn'
                                            , 'c.main_count'
                                            , 'c.sub_count')
                                   ->where('contract_classes.contract_id', $id)
                                   ->orderBy('contract_classes.class_day', 'asc')
                                   ->orderBy('contract_classes.time_from', 'asc')
                                   ->orderBy('contract_classes.class_category_id', 'asc')
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
                                    ->where(function($query) use ($request){
                                        $searchType = $request->input('searchType');
                                        $searchWord = $request->input('searchWord');
                                        if(!empty($request->input('searchType'))){
                                            $query->where('cl.gubun','=',"{$searchType}");
                                        }
                                        if(!empty($request->input('searchWord'))){
                                            $query->where('cl.name','LIKE',"{$searchWord}%");
                                        }
                                   })
                                    ->orderBy('contracts.created_at', 'desc')
                                    ->paginate($perPage);
        $contractList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));

        $clientGubunList = CommonCode::getCommonCode('client_gubun');
 //       dd(DB::getQueryLog());
        return view('mgmt.contract.list', ['pageTitle'=>$this->pageTitle, 'clientGubunList'=>$clientGubunList, 'contractList'=>$contractList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

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

        $client_id = $contract[0]->client_id;

        $classList = ContractClass::join('class_categories', 'contract_classes.class_category_id', '=', 'class_categories.id')
                                    ->select('contract_classes.*', 'class_categories.class_name' )
                                    ->where('contract_id', $id)
                                    ->where('class_status', '=', 0)
                                    ->get();

        //dd(DB::getQueryLog());
        $client = new Client();
        $result = $client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                        ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->select('clients.*', 'c.code_value')
                            ->where('clients.id', $client_id)->get();


        $codelist = CommonCode::getCommonCode('contract_status');
        $financeList = CommonCode::getCommonCode('finance_type');
        $classItems = ClassCategory::orderBy('class_group', 'asc', 'class_order', 'asc')->get(['id', 'class_name']);

        $today = date("Y-m-d", time());
        //echo($result[0]->id);
        //dd(DB::getQueryLog());
        return view('mgmt.contract.update', ['pageTitle'=>$this->pageTitle,'client'=>$result[0], 'contract'=>$contract[0], 'classList'=>$classList, 'commonCode'=> $codelist, 'financeList'=> $financeList, 'classItems'=> $classItems, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus,  'today'=>$today]);
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
//dd($classJson);
        $contract->fill($request->input());
        try {
            DB::beginTransaction();

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
                        'outcome_material_cost'     =>  $contract->outcome_material_cost,
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
                $inputClass->class_sub_name         = $class['class_sub_name'];
                $inputClass->class_target           = $class['class_target'];
                $inputClass->class_number           = $class['class_number'];
                $inputClass->class_count            = $class['class_count'];
                $inputClass->class_order            = $class['class_order'];
                $inputClass->main_count             = $class['main_count'];
                $inputClass->sub_count              = $class['sub_count'];
                $inputClass->finance                = $class['finance'];
                $inputClass->sub_finance            = $class['sub_finance'];
                $inputClass->class_type             = $class['class_type'];
                $inputClass->online_type            = $class['online_type'];

                if('I' == $class['action_type']){
                    $inputClass->save();
                }else if('D' == $class['action_type']){
                    ClassLector::where('contract_class_id', $class['class_id'])
                    ->delete();

                    $inputClass->where('id', $class['class_id'])
                    ->delete();
                }else if('U' == $class['action_type']){
                    $inputClass->where('id', $class['class_id'] )
                                ->update([
                                    'class_target'  =>  $inputClass->class_target,
                                    'class_number'  =>  $inputClass->class_number,
                                    'class_count'  =>  $inputClass->class_count,
                                    'class_order'  =>  $inputClass->class_order,
                                    'finance'       =>  $inputClass->finance,
                                    'sub_finance'   =>  $inputClass->sub_finance,
                                    'class_type'    =>  $inputClass->class_type,
                                    'online_type'   =>  $inputClass->online_type,
                                ]);
                }

            }
  //          dd(DB::getQueryLog());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }
        return redirect()->route('mgmt.contract.read', ['id' =>$id , 'client_id' =>$client_id, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus ]) ;
    }


    public function deleteDo(Request $request){

        $contract_id = $request->input('contract_id');

        try {
            DB::beginTransaction();

            $classList = ContractClass::where('contract_id', $contract_id)
                                        ->get();

            foreach($classList as $key){
                ClassLector::where('contract_class_id', $key->id)
                            ->delete();
            }

            ContractClass::where('contract_id', $contract_id)
                         ->delete();

            Contracts::where('id', $contract_id)
                     ->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }

    public function updateContractStatus(Request $request){


        $contract_id = $request->input('contract_id');
        $status_code = $request->input('status_code');


        if(4==$status_code){
            $con = ContractClass::where('contract_id',$contract_id)
                                ->where('lector_apply_yn',0)
                                ->get();

            if(!empty($con) && $con->count()>0){
                return response()->json(['msg'=>'강사 배정중입니다. 강사배정 완료 후 다시 시도해 주세요.']);
            }
        }

        Contracts::where('id',$contract_id)
                   ->update([
                        'status'=> $status_code
                    ]);

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }


    public function popupUpdateClass(Request $request){

        $id = $request->input('id');
        $contract_id = $request->input('contract_id');
        DB::enableQueryLog();
        $classList = ContractClass::join('class_categories', 'contract_classes.class_category_id', '=', 'class_categories.id')
                                    ->join('common_codes as c1', function($join){
                                        $join->on('c1.code_id','=', 'contract_classes.finance')
                                            ->where('c1.code_group', '=','finance_type');
                                        }
                                    )
                                    ->leftjoin('common_codes as c2', function($join){
                                        $join->on('c2.code_id','=', 'contract_classes.sub_finance')
                                            ->where('c2.code_group', '=','finance_type');
                                        }
                                    )
                                    ->select('contract_classes.*'
                                            , 'class_categories.class_gubun'
                                            , 'class_categories.class_name'
                                           // , 'c1.code_value as finance'
                                           // , 'c2.code_value as sub_finance'
                                            )
                                    ->where('contract_classes.contract_id', $contract_id)
                                    ->where('contract_classes.id', $id)
                                    ->first();
        //dd(DB::getQueryLog());

        $financeList = CommonCode::getCommonCode('finance_type');
        return view('mgmt.contract.popupUpdateClass', ['class_id'=>$id, 'contract_id'=>$contract_id, 'financeList'=>$financeList, 'classList'=>$classList ]);

    }

    public function popupUpdateClassDo(Request $request){
    
        $contract_class_id = $request->input('class_id');
        $contract_id = $request->input('contract_id');
        $class_sub_name = $request->input('class_sub_name');
        $class_day = $request->input('class_day');
        $time_from = $request->input('time_from');
        $time_to = $request->input('time_to');
        $class_target = $request->input('class_target');
        $class_number = $request->input('class_number');
        $class_count = $request->input('class_count');
        $class_order = $request->input('class_order');
        $finance = $request->input('finance');
        $sub_finance = $request->input('sub_finance');
        $class_type = $request->input('class_type');
        $online_type = $request->input('online_type');

        
        try{

            DB::beginTransaction();

            ContractClass::where('id', $contract_class_id )
                            ->update([
                                'class_sub_name'=>  $class_sub_name,
                                'class_day'     =>  $class_day,
                                'time_from'     =>  $time_from,
                                'time_to'       =>  $time_to,

                                'class_target'  =>  $class_target,
                                'class_number'  =>  $class_number,
                                'class_count'   =>  $class_count,
                                'class_order'   =>  $class_order,
                                'finance'       =>  $finance,
                                'sub_finance'   =>  $sub_finance,
                                'class_type'    =>  $class_type,
                                'online_type'   =>  $online_type,
                            ]);

            //완료강좌 금액 수정
            $myCol = new MyLectureController();
            $res = $myCol->calcuClassLector($contract_class_id);

            if(!$res){
                DB::rollBack();
                return response()->json(['msg'=>'수정중 오류가 발생하였습니다.']);;
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg'=>'수정중 오류가 발생하였습니다.']);;
        }


        

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);;
    }

    public function exportExcel(Request $request){
        $searchWord = $request->input('searchWord');
        $searchType = $request->input('searchType');
        return (new ContractExport)->forSearch($searchWord, $searchType)->download('ContractReport.xlsx');

    }

}
