<?php

namespace App\Http\Controllers\mgmt\contract;

use App\Http\Controllers\Controller;
use App\Models\Client;
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

        $result[0]->id = $id;
        return view('mgmt.contract.create', [ 'client'=>$result[0] ]);
    }

}
