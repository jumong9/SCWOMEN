<?php

namespace App\Http\Controllers\mgmt\acreport;

use App\Http\Controllers\Controller;
use App\Models\ClassLector;
use App\Models\ClassReport;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use App\Models\UserFile;
use DateTime;
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

        $searcFromDate = $request->input('searcFromDate');
        $searcToDate = $request->input('searcToDate');

        if(empty($searcFromDate) || empty($searcToDate)){
            $searcFromDate = date("Y-m", time()) .'-01';
            $dayCount = new DateTime( $searcFromDate );
            $searcToDate = $dayCount->format( 'Y-m-t' );
        }

        DB::enableQueryLog();
        $user_id = Auth::id();

        $classList = ClassReport::join('contract_classes as b', 'b.id' ,'=', 'class_reports.contract_class_id')
                                    ->join('contracts as c', 'c.id', '=','b.contract_id')
                                    ->join('clients as d', 'd.id', '=', 'c.client_id')
                                    ->join('class_categories as f', 'f.id', '=', 'class_reports.class_category_id')
                                    ->select('class_reports.*'
                                            , 'b.class_number', 'b.class_type', 'b.class_target','b.id as contract_class_id'
                                            , 'd.name AS client_name'
                                            , 'f.class_name'
                                    )
                                    ->where('d.name','LIKE',"{$searchWord}%")
                                    ->where(function ($query) use ($searcFromDate, $searcToDate){
                                        if(!empty($searcFromDate) && !empty($searcToDate) ){
                                            $query->whereBetween('class_reports.class_day', [$searcFromDate, $searcToDate]);
                                        }
                                    })
                                    ->orderBy('class_reports.class_day', 'desc')
                                    ->orderBy('class_reports.created_at', 'desc')
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus, 'searcFromDate'=>$searcFromDate , 'searcToDate'=>$searcToDate));


        //dd(DB::getQueryLog());
        return view('mgmt.acreport.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus, 'searcFromDate'=>$searcFromDate , 'searcToDate'=>$searcToDate] );

    }


    public function printPopup(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');

        $ids = $request->input('ids');
        $inputIds = explode(',', $ids);
        DB::enableQueryLog();
        $user_id = Auth::id();
        //echo Auth::user()->grade;

        $classList = ClassReport::join('contract_classes as b', 'b.id' ,'=', 'class_reports.contract_class_id')
                                    ->join('contracts as c', 'c.id', '=','b.contract_id')
                                    ->join('clients as d', 'd.id', '=', 'c.client_id')
                                    ->join('class_categories as f', 'f.id', '=', 'class_reports.class_category_id')
                                    ->join('user_files as g', 'g.id', 'class_reports.file_id')
                                    ->select('class_reports.*'
                                            , 'b.class_number', 'b.class_type', 'b.class_target'
                                            , 'd.name AS client_name'
                                            , 'f.class_name'
                                            , 'g.file_name', 'g.file_path'
                                    )
                                    ->where('d.name','LIKE',"{$searchWord}%")
                                    ->whereIn('class_reports.id', $inputIds)
                                    ->where(function ($query) use ($request){
                                        $searcFromDate = $request->input('searcFromDate');
                                        $searcToDate = $request->input('searcToDate');
                                        if(!empty($searcFromDate) && !empty($searcToDate) ){
                                            $query->whereBetween('class_reports.class_day', [$searcFromDate, $searcToDate]);
                                        }
                                    })
                                    ->orderBy('class_reports.class_day', 'desc')
                                    ->orderBy('class_reports.created_at', 'desc')
                                    ->get();

        //dd(DB::getQueryLog());

        return view('mgmt.acreport.printPopup', [ 'pageTitle'=>$this->pageTitle,'classList'=>$classList ] );

    }


    public function read(Request $request){

        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');
        $searcFromDate = $request->input('searcFromDate');
        $searcToDate = $request->input('searcToDate');


        $id = $request->input('id');

        $classList = ContractClass::join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_category_user as c', 'c.class_category_id', '=', 'contract_classes.class_category_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            )
                                    ->where('contract_classes.id',$id)
                                    ->get();
        //dd(DB::getQueryLog());
        $contract = Contracts::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'contracts.status')
                                            ->where('c.code_group', '=','contract_status');
                                    }
                                )->where('contracts.id',$classList[0]->contract_id)
                                ->get();



        $contract[0]->id=$id;

        $client = Client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                     ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $contract[0]->client_id)
                            ->get();

        $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
                        ->where('contract_class_id',$id)
                        ->orderBy('main_yn','desc')
                        ->get();

        $calssReport = ClassReport::where('contract_class_id', $id)
                                    ->first();
        $file_id = $calssReport->file_id;

        $fileInfo=null;
        if(!empty($file_id)){
            $fileInfo = UserFile::where('id', $file_id)
                              ->get();
        }


        return view('mgmt.acreport.read', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'calssReport'=>$calssReport, 'fileInfo'=>$fileInfo, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus, 'searcFromDate'=>$searcFromDate , 'searcToDate'=>$searcToDate]);

    }


}
