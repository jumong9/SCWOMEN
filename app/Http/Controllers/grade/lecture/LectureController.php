<?php

namespace App\Http\Controllers\grade\lecture;

use App\Http\Controllers\Controller;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Http\Request;
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

        $classList = ContractClass::join('class_categories', 'contract_classes.class_category_id', '=', 'class_categories.id')
                                    ->select('contract_classes.*', 'class_categories.class_name' )
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
        $contractList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


 //       dd(DB::getQueryLog());
        return view('grade.lecture.list', ['pageTitle'=>$this->pageTitle,'contractList'=>$contractList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

    }


}
