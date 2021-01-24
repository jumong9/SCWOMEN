<?php

namespace App\Http\Controllers\grade\paycalculate;

use App\Exports\MyPayCalculateExport;
use App\Http\Controllers\Controller;
use App\Models\ClassCalculate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayCalculateController extends Controller{

    public function __construct(){
        $this->pageTitle = "강사비조회";
    }



    public function list(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        $searchFromMonth = $request->input('searchFromMonth');


        if(empty($searchFromMonth)){

            $month = date("Y-m-d", time());
            $prevMonth = strtotime("1 months ago", strtotime($month));
            $searchFromMonth = date("Y-m", $prevMonth);
        }
        $user_id = Auth::id();
        // DB::enableQueryLog();

        $classList = ClassCalculate::where('calcu_month', $searchFromMonth)
                                     ->where('user_id', $user_id)
                                     ->where(function ($query) use ($searchWord){
                                        if(!empty($searchWord)){
                                            $query->where('client_name', 'LIKE',"{$searchWord}%");
                                        }
                                     })
                                     ->orderByRaw('ISNULL(user_name), user_name ASC')
                                     ->orderBy('user_id', 'asc')
                                     ->orderByRaw('ISNULL(class_day), class_day ASC')
                                     ->orderBy('my_main_count', 'asc')
                                     ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus, 'searchFromMonth'=>$searchFromMonth));


        //dd(DB::getQueryLog());
        return view('grade.paycalculate.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus, 'searchFromMonth'=>$searchFromMonth] );

    }


    public function popupPayDocument(Request $request){
        $searchFromMonth = $request->input('searchFromMonth');
        $searchWord = $request->input('searchWord');

        if(empty($searchFromMonth)){

            $month = date("Y-m-d", time());
            $prevMonth = strtotime("1 months ago", strtotime($month));
            $searchFromMonth = date("Y-m", $prevMonth);
        }

        $thisYear = date("Y", time());
        $user_id = Auth::id();
        $userInfo = Auth::user();
        $classList = ClassCalculate::where('calcu_month', $searchFromMonth)
                                     ->where('user_id', $user_id)
                                     ->where(function ($query) use ($searchWord){
                                        if(!empty($searchWord)){
                                            $query->where('client_name', 'LIKE',"{$searchWord}%");
                                        }
                                     })
                                     ->orderByRaw('ISNULL(user_name), user_name ASC')
                                     ->orderBy('user_id', 'asc')
                                     ->orderByRaw('ISNULL(class_day), class_day ASC')
                                     ->orderBy('my_main_count', 'asc')
                                     ->get();

        return view('grade.paycalculate.popupPayDocument', ['classList'=>$classList, 'userInfo'=>$userInfo, 'thisYear'=>$thisYear]);

    }


    public function exportExcel(Request $request){

        $searchFromMonth = $request->input('searchFromMonth');

        if(empty($searchFromMonth)){
            $searchFromDate = date("Y-m", time()) .'-01';
        }

        return (new MyPayCalculateExport)->forYear($searchFromMonth)->download('MyCalculateReport.xlsx');
    }


}
