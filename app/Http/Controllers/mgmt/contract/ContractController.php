<?php

namespace App\Http\Controllers\mgmt\contract;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\Client;
use App\Models\CommonCode;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller{
    //

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
        return view('mgmt.contract.create', [ 'client'=>$result[0], 'commonCode'=> $codelist, 'classItems'=> $classItems ]);
    }


    public function createDo(Request $request){

        $classTargetList = $request->get('classTargetList');
        $classJson = json_decode($classTargetList, true);
        $client_id = $request->input('client_id');

        // $contracts = new Contracts();
        // $contracts->client_id           =  $client_id;
        // $contracts->name                =  $request->input('name');
        // $contracts->email               =  $request->input('email');
        // $contracts->phone               =  $request->input('phone');
        // $contracts->phone2              =  $request->input('phone2');
        // $contracts->class_cost          =  $request->input('class_cost');
        // $contracts->class_total_cost    =  $request->input('class_total_cost');
        // $contracts->material_cost       =  $request->input('material_cost');
        // $contracts->material_total_cost =  $request->input('material_total_cost');
        // $contracts->total_cost          =  $request->input('total_cost');
        // $contracts->paid_yn             =  $request->input('paid_yn');
        // $contracts->status              =  $request->input('status');
        // $contracts->comments            =  $request->input('comments');

        $contrats_arr = [
            "client_id"           =>  $client_id,
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


        return redirect()->route('mgmt.contract.read', ['id' =>$contract_id , 'client_id' =>$client_id ]) ;
    }


    public function read(Request $request){
//DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');
        $id = $request->input('id');

        $contract = Contracts::where('id',$id)->get();
        $client_id = $contract[0]->client_id;

        $classList = ContractClass::where('contract_id', $id)->get();

        $client = new Client();
        $result = $client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                    ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $client_id)->get();
//dd(DB::getQueryLog());
        return view('mgmt.contract.read', ['client'=>$result[0], 'contract'=>$contract[0], 'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
    }

}
