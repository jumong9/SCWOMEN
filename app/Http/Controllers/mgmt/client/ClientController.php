<?php

namespace App\Http\Controllers\mgmt\client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CommonCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller{


    /**
     * 사용자 목록
     */
    public function list(Request $request){


        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');


        //DB::enableQueryLog();where('users.name','LIKE',"{$searchWord}%");
        $clients = Client::where('clients.name','LIKE',"{$searchWord}%")
                           ->orderBy('clients.created_at', 'desc')
                           ->paginate($perPage);;

        $clients->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));

        return view('mgmt.client.list', ['clientlist'=>$clients, 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]);

    }


    /**
     * 수요처 등록 화면
     */
    public function create(){
    //DB::enableQueryLog();
        $commonCode = CommonCode::where('code_group','=','client_gubun')
                                    ->orderBy('order', 'asc')
                                    ->get();
    //dd(DB::getQueryLog());
        return view('mgmt.client.create', [ 'commonCode'=> $commonCode ]);
    }


}
