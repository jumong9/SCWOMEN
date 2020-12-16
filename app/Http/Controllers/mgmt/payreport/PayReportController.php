<?php

namespace App\Http\Controllers\mgmt\payreport;

use App\Exports\CalculatorExport;
use App\Http\Controllers\Controller;
use App\Models\ContractClass;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayReportController extends Controller{
    public function __construct(){

        $this->filePath = "uploads/".date("Y")."/acreport";
        $this->pageTitle = "강사비 지급대상";
    }


    public function list(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        $searcFromDate = $request->input('searcFromDate');
        $searcToDate = $request->input('searcToDate');

        if(empty($searcFromDate) || empty($searcToDate)){
            $searcFromDate = date("Y-m", time()) .'-01';
            $dayCount = new DateTime( $searcFromDate );
            $searcToDate = $dayCount->format( 'Y-m-t' );
        }

        DB::enableQueryLog();

        $classList = ContractClass::join('class_categories as b', 'b.id' ,'=', 'contract_classes.class_category_id')
                                    ->join('class_lectors as c', 'c.contract_class_id', '=','contract_classes.id')
                                    ->join('contracts as d', 'd.id', '=', 'contract_classes.contract_id')
                                    ->join('users as e', 'e.id', '=', 'c.user_id')
                                    ->join('common_codes as f', function($join){
                                        $join->on('f.code_id','=', 'contract_classes.class_status')
                                                ->where('f.code_group', '=','contract_class_status');
                                        }
                                    )
                                    ->select('contract_classes.*'
                                            , 'b.class_name'
                                            , 'c.main_yn'
                                            , 'c.lector_cost'
                                            , 'c.main_count as my_main_count'
                                            , 'c.sub_count as my_sub_count'
                                            , 'c.user_id'
                                            , 'd.client_name'
                                            , 'f.code_value as class_status_value'
                                            , 'e.name'
                                            , 'e.id as user_id'
                                            , 'c.lector_cost as tot'
                                            , DB::raw('round(c.lector_cost * 0.03) AS i_tax')
                                            , DB::raw('round(c.lector_cost * 0.003) AS r_tax')
                                            , DB::raw('c.lector_cost - round(c.lector_cost * 0.033) AS pay')
                                           // , DB::raw('(case when c.main_yn = 1 then c.lector_cost + contract_classes.material_cost ELSE c.lector_cost END ) AS tot')
                                           // , DB::raw('round((case when c.main_yn = 1 then c.lector_cost + contract_classes.material_cost ELSE c.lector_cost END)*0.03) AS i_tax')
                                           // , DB::raw('round((case when c.main_yn = 1 then c.lector_cost + contract_classes.material_cost ELSE c.lector_cost END)*0.003) AS r_tax')
                                           // , DB::raw('(case when c.main_yn = 1 then c.lector_cost + contract_classes.material_cost ELSE c.lector_cost END ) - round((case when c.main_yn = 1 then c.lector_cost + contract_classes.material_cost ELSE c.lector_cost END )*0.033) AS pay')
                                    )
                                    ->where('contract_classes.class_status', '>', '0')
                                    ->where(function ($query) use ($searcFromDate, $searcToDate){

                                        if(!empty($searcFromDate) && !empty($searcToDate) ){
                                            $query->whereBetween('contract_classes.class_day', [$searcFromDate, $searcToDate]);
                                        }
                                    })
                                    ->where('e.name','LIKE',"{$searchWord}%")
                                    ->orderBy('e.name', 'asc')
                                    ->orderBy('e.id', 'asc')
                                    ->orderBy('contract_classes.class_day', 'asc')
                                    ->orderBy('contract_classes.time_from', 'asc')
                                //    ->orderBy('contract_classes.updated_at', 'desc')
                                //    ->groupBy(DB::raw('e.id with rollup'))
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus, 'searcFromDate'=>$searcFromDate , 'searcToDate'=>$searcToDate));


        //dd(DB::getQueryLog());
        return view('mgmt.payreport.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus, 'searcFromDate'=>$searcFromDate , 'searcToDate'=>$searcToDate] );

    }


    public function exportExcel(Request $request){

        $searcFromDate = $request->input('searcFromDate');
        $searcToDate = $request->input('searcToDate');

        if(empty($searcFromDate) || empty($searcToDate)){
            $searcFromDate = date("Y-m", time()) .'-01';
            $dayCount = new DateTime( $searcFromDate );
            $searcToDate = $dayCount->format( 'Y-m-t' );
        }

        return (new CalculatorExport)->forYear($searcFromDate, $searcToDate)->download('PayReport.xlsx');
    }


}
