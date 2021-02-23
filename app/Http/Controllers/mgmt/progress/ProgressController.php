<?php

namespace App\Http\Controllers\mgmt\progress;

use App\Exports\ProgressExport;
use App\Http\Controllers\Controller;
use App\Models\ContractClass;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    public function __construct(){

        $this->filePath = "uploads/".date("Y")."/acreport";
        $this->pageTitle = "강의진행정보";
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
            // $searcFromDate = date("Y-m", time()) .'-01';
            // $dayCount = new DateTime( $searcFromDate );
            // $searcToDate = $dayCount->format( 'Y-m-t' );

            $searcFromDate = date("Y-m", time()) .'-01';
            $prevMonthDate = strtotime("1 months ago", strtotime($searcFromDate));
            $dayCount = new DateTime( $searcFromDate );
            $searcToDate = $dayCount->format( 'Y-m-t' );
            $searcFromDate = date("Y-m", $prevMonthDate).'-01';
        }

        //echo Auth::user()->grade;
        DB::enableQueryLog();

        $classList = ContractClass::join('contracts', 'contracts.id', '=','contract_classes.contract_id')
                                    ->join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->leftjoin('class_lectors as le', function($join){
                                        $join->on('le.contract_class_id', '=','contract_classes.id')
                                             ->where('le.main_yn', 1);
                                        }
                                    )
                                    ->leftjoin('users as u', 'u.id', '=', 'le.user_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            , 'contracts.id as contract_id'
                                            , 'u.name as user_name'
                                            )
                                    ->where('contracts.status','>',1)
                                   // ->where('contracts.id', "{$searchWord}")
                                    ->where(function ($query) use ($request){
                                        $searchType = $request->input('searchType');
                                        $searcFromDate = $request->input('searcFromDate');
                                        $searcToDate = $request->input('searcToDate');
                                        $searchWord = $request->input('searchWord');

                                        if(empty($searcFromDate) || empty($searcToDate)){
                                            $searcFromDate = date("Y-m", time()) .'-01';
                                            $prevMonthDate = strtotime("1 months ago", strtotime($searcFromDate));
                                            $dayCount = new DateTime( $searcFromDate );
                                            $searcToDate = $dayCount->format( 'Y-m-t' );
                                            $searcFromDate = date("Y-m", $prevMonthDate).'-01';
                                        }

                                        if(!empty($searcFromDate) && !empty($searcToDate) ){
                                            $query->whereBetween('contract_classes.class_day', [$searcFromDate, $searcToDate]);
                                        }

                                        if(!empty($searchWord)){
                                            if('contract_id'==$searchType) {
                                                $query->where('contracts.id', "{$searchWord}");
                                            }elseif('client_name'==$searchType) {
                                                $query->where('b.name', 'LIKE', "{$searchWord}%");
                                            }
                                        }
                                    })
                                    //->orderBy('contract_classes.created_at', 'desc')
                                    ->orderBy('contract_classes.contract_id', 'desc')
                                    ->orderBy('contract_classes.class_day', 'asc')
                                    ->orderBy('contract_classes.time_from', 'asc')
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus, 'searcFromDate'=>$searcFromDate , 'searcToDate'=>$searcToDate));


       // dd(DB::getQueryLog());
        return view('mgmt.progress.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus, 'searcFromDate'=>$searcFromDate , 'searcToDate'=>$searcToDate] );

    }



    public function exportExcel(Request $request){

        $searcFromDate = $request->input('searcFromDate');
        $searcToDate = $request->input('searcToDate');
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');

        if(empty($searcFromDate) || empty($searcToDate)){
            $searcFromDate = date("Y-m", time()) .'-01';
            $dayCount = new DateTime( $searcFromDate );
            $searcToDate = $dayCount->format( 'Y-m-t' );
        }

        return (new ProgressExport)->forYear($searcFromDate, $searcToDate, $searchType, $searchWord)->download('ProgressReport.xlsx');
    }



}
