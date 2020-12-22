<?php

namespace App\Http\Controllers\mgmt\client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CommonCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller{

    public $pageTitle;

    public function __construct(){
        $this->pageTitle = "수요처관리";
    }


    /**
     * 사용자 목록
     */
    public function list(Request $request){


        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');


        //DB::enableQueryLog();where('users.name','LIKE',"{$searchWord}%");
        $clients = Client::where('clients.name','LIKE',"{$searchWord}%")
                           ->orderBy('clients.created_at', 'desc')
                           ->paginate($perPage);

        $clients->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));

        return view('mgmt.client.list', ['contentslist'=>$clients, 'pageTitle'=>$this->pageTitle, 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]);

    }


    /**
     * 수요처 등록 화면
     */
    public function create(){
        //DB::enableQueryLog();
        // $commonCode = CommonCode::where('code_group','=','client_gubun')
        //                             ->orderBy('order', 'asc')
        //                             ->get();

        $codelist = CommonCode::getCommonCode('client_gubun');
        //dd(DB::getQueryLog());
        return view('mgmt.client.create', [ 'commonCode'=> $codelist, 'pageTitle'=>$this->pageTitle ]);
    }

    /**
     * 수요처 등록 화면
     */
    public function createDo(Request $request, Client $client){
        $client->fill($request->input())
                ->save();

        return redirect()->route('mgmt.client.list')->withInput([1, 2]);
    }

    /**
     * 수요처 상세 화면
     */
    public function read(Request $request, Client $client){

        DB::enableQueryLog();

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');

        $perPage = $request->input('perPage');
        $page = $request->input('page');

        $id = $request->input('id');
        $result = $client::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'clients.gubun')
                                         ->where('c.code_group', '=','client_gubun');
                                    }
                                )
                            ->where('clients.id', $id)->get();
        //dd(DB::getQueryLog());
        $result[0]->id=$id;
        return view('mgmt.client.read', ['client'=>$result[0] , 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );
    }


    /**
     * 수요처 수정 화면
     */
    public function update(Request $request, Client $client){

        //DB::enableQueryLog();

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');


        $codelist = CommonCode::getCommonCode('client_gubun');

        $id = $request->input('id');
        $result = $client::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'clients.gubun')
                                         ->where('c.code_group', '=','client_gubun');
                                    }
                                )
                            ->where('clients.id', $id)->get();
        //dd(DB::getQueryLog());
        $result[0]->id=$id;

        return view('mgmt.client.update', ['client'=>$result[0], 'pageTitle'=>$this->pageTitle, 'commonCode'=> $codelist, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );
    }


    /**
     * 수요처 수정
     */
    public function updateDo(Request $request, Client $client){

       // DB::enableQueryLog();

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');

        $id = $request->input('id');
        $client->fill($request->input());

        $client->where('id', $id)
                ->update([
                    'name'=>$client->name,
                    'gubun'=>$client->gubun,
                    'client_tel'=>$client->client_tel,
                    'client_fax'=>$client->client_fax,
                    'office_tel'=>$client->office_tel,
                    'office_fax'=>$client->office_fax,
                    'address'=>$client->address,
                    'zipcode'=>$client->zipcode,
                ]);


        //dd(DB::getQueryLog());
        return redirect()->route('mgmt.client.read', ['id'=>$id, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );
    }

}
