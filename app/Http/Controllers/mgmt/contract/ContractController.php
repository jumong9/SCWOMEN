<?php

namespace App\Http\Controllers\mgmt\contract;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\Client;
use App\Models\CommonCode;
use Illuminate\Http\Request;

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


        //contract 정보 생성

        //contract class 정보 생성

        return 'ok';
    }

}
