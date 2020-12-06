<?php

namespace App\Http\Controllers\mgmt\acreport;

use App\Http\Controllers\Controller;
use App\Models\ClassReport;
use App\Models\ContractClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcReportController extends Controller{

    public function __construct(){

        $this->filePath = "uploads/".date("Y")."/acreport";
        $this->pageTitle = "활동일지관리";
    }

    public function list(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');

        $ids = $request->input('ids');
//dd ($ids);

        DB::enableQueryLog();
        $user_id = Auth::id();
        //echo Auth::user()->grade;

        $classList = ClassReport::join('contract_classes as b', 'b.id' ,'=', 'class_reports.contract_class_id')
                                    ->join('contracts as c', 'c.id', '=','b.contract_id')
                                    ->join('clients as d', 'd.id', '=', 'c.client_id')
                                    ->join('class_categories as f', 'f.id', '=', 'class_reports.class_category_id')
                                    ->select('class_reports.*'
                                            , 'b.class_number', 'b.class_type', 'b.class_target'
                                            , 'd.name AS client_name'
                                            , 'f.class_name'
                                    )
                                    ->where('d.name','LIKE',"{$searchWord}%")
                      //              ->whereIn('class_reports.id', $ids)
                                    ->orderBy('class_reports.class_day', 'desc')
                                    ->orderBy('class_reports.created_at', 'desc')
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


        //dd(DB::getQueryLog());
        return view('mgmt.acreport.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

    }

}
