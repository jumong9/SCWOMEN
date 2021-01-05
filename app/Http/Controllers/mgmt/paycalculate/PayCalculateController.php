<?php

namespace App\Http\Controllers\mgmt\paycalculate;

use App\Exports\ClassCalculateExport;
use App\Http\Controllers\Controller;
use App\Models\ClassCalculate;
use App\Models\ContractClass;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PayCalculateController extends Controller
{
    public function __construct(){
        $this->pageTitle = "강사비 정산";
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

        // DB::enableQueryLog();

        $classList = ClassCalculate::where('calcu_month', $searchFromMonth)
                                     ->where(function ($query) use ($searchWord){
                                        if(!empty($searchWord)){
                                            $query->where('user_name', 'LIKE',"{$searchWord}%");
                                        }
                                     })
                                     ->orderByRaw('ISNULL(user_name), user_name ASC')
                                     ->orderBy('user_id', 'asc')
                                     ->orderByRaw('ISNULL(class_day), class_day ASC')
                                     ->orderBy('my_main_count', 'asc')
                                     ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus, 'searchFromMonth'=>$searchFromMonth));


        //dd(DB::getQueryLog());
        return view('mgmt.paycalculate.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus, 'searchFromMonth'=>$searchFromMonth] );

    }


    public function createDo(Request $request){
        // DB::enableQueryLog();
        $searchFromMonth = $request->input('searchFromMonth');
        $searchFromDate = "";
        $searchToDate = "";

        if(empty($searchFromMonth)){
            return response()->json(['msg'=>'잘못된 요청 입니다.']);
        }else{

           // dd($prevMonth);
            $searchFromDate = date("Y-m", strtotime($searchFromMonth)) .'-01';
            $dayCount = new DateTime( $searchFromDate );
            $searchToDate = $dayCount->format( 'Y-m-t' );
        }

        try {
            DB::beginTransaction();

            ClassCalculate::where('calcu_month', $searchFromMonth)
                            ->delete();

            $targetClassList = DB::table('contract_classes')
                                            ->join('class_categories as b', 'b.id' ,'=', 'contract_classes.class_category_id')
                                            ->join('class_lectors as c', 'c.contract_class_id', '=','contract_classes.id')
                                            ->join('contracts as d', 'd.id', '=', 'contract_classes.contract_id')
                                            ->join('users as e', 'e.id', '=', 'c.user_id')
                                            ->select( DB::raw("'$searchFromMonth'")
                                                    , 'contract_classes.contract_id'
                                                    , 'contract_classes.client_id'
                                                    , 'd.client_name'
                                                    , 'contract_classes.class_category_id'
                                                    , 'b.class_gubun'
                                                    , 'b.class_name'
                                                    , 'contract_classes.class_sub_name'
                                                    , 'contract_classes.class_day'
                                                    , 'contract_classes.class_count'
                                                    , 'contract_classes.class_order'
                                                    , 'contract_classes.class_type'
                                                    , 'contract_classes.online_type'
                                                    , 'c.main_yn'
                                                    , 'c.main_count as my_main_count'
                                                    , 'c.sub_count as my_sub_count'
                                                    , 'e.id as user_id'
                                                    , 'e.name as user_name'
                                                    , 'c.lector_main_count'
                                                    , 'c.lector_main_cost'
                                                    , 'c.lector_extra_count'
                                                    , 'c.lector_extra_cost'
                                                    , 'c.lector_cost as tot'
                                                    , DB::raw('round(c.lector_cost * 0.03) AS i_tax')
                                                    , DB::raw('round(c.lector_cost * 0.003) AS r_tax')
                                                    , DB::raw('c.lector_cost - round(c.lector_cost * 0.033) AS pay')
                                            )
                                            ->where('contract_classes.class_status', '>', '0')
                                            ->where(function ($query) use ($searchFromDate, $searchToDate){

                                                if(!empty($searchFromDate) && !empty($searchToDate) ){
                                                    $query->whereBetween('contract_classes.class_day', [$searchFromDate, $searchToDate]);
                                                }
                                            })
                                            ->orderBy('e.name', 'asc')
                                            ->orderBy('e.id', 'asc')
                                            ->orderBy('contract_classes.class_day', 'asc')
                                            ->orderBy('contract_classes.time_from', 'asc')
                                            ;

            if($targetClassList->count()==0){
                return response()->json(['msg'=>'정산 대상이 존재하지 않습니다.']);
            }

            DB::table('class_calculates')->insertUsing([
                                                           'calcu_month'
                                                         , 'contract_id'
                                                         , 'client_id'
                                                         , 'client_name'
                                                         , 'class_category_id'
                                                         , 'class_gubun'
                                                         , 'class_name'
                                                         , 'class_sub_name'
                                                         , 'class_day'
                                                         , 'class_count'
                                                         , 'class_order'
                                                         , 'class_type'
                                                         , 'online_type'
                                                         , 'main_yn'
                                                         , 'my_main_count'
                                                         , 'my_sub_count'
                                                         , 'user_id'
                                                         , 'user_name'
                                                         , 'lector_main_count'
                                                         , 'lector_main_cost'
                                                         , 'lector_extra_count'
                                                         , 'lector_extra_cost'
                                                         , 'tot_cost'
                                                         , 'i_tax'
                                                         , 'r_tax'
                                                         , 'calcu_cost'
                                                        ], $targetClassList);


            $calcuList = ClassCalculate::where('calcu_month', $searchFromMonth)
                                         ->select(
                                              'calcu_month'
                                            , 'user_id'
                                            , 'user_name'
                                            , DB::raw('sum(tot_cost) as tot_cost')
                                            , DB::raw('sum(i_tax) as i_tax')
                                            , DB::raw('sum(r_tax) as r_tax')
                                            , DB::raw('sum(calcu_cost) as calcu_cost')
                                         )
                                         ->groupBy('calcu_month')
                                         ->groupBy('user_name')
                                         ->groupBy('user_id')
                                         ->get();

            $sum_tot_cost = 0;
            $sum_i_tax = 0;
            $sum_r_tax = 0;
            $sum_calcu_cost = 0;

            foreach($calcuList as $key){
                $sumCalcu = new ClassCalculate();
                $sumCalcu->calcu_month = $searchFromMonth;
                $sumCalcu->user_id = $key->user_id;
                $sumCalcu->user_name = $key->user_name;
                $sumCalcu->tot_cost = $key->tot_cost;
                $sumCalcu->i_tax = $key->i_tax;
                $sumCalcu->r_tax = $key->r_tax;
                $sumCalcu->calcu_cost = $key->calcu_cost;

                if($key->tot_cost <= 30000){
                    $sumCalcu->i_tax = 0;
                    $sumCalcu->r_tax = 0;;
                    $sumCalcu->calcu_cost = $key->tot_cost;
                }

                $last_cost = substr($key->calcu_cost,-1);
                if( $last_cost<= 5){
                    $sumCalcu->calcu_cost = $key->calcu_cost + 10 - $last_cost;
                    $sumCalcu->r_tax -= $last_cost;
                }

                $sumCalcu->save();

                $sum_tot_cost += $sumCalcu->tot_cost;
                $sum_i_tax += $sumCalcu->i_tax;
                $sum_r_tax += $sumCalcu->r_tax;
                $sum_calcu_cost += $sumCalcu->calcu_cost;
            }

            if($sum_calcu_cost > 0) {
                $sumCalcu = new ClassCalculate();
                $sumCalcu->calcu_month = $searchFromMonth;
                $sumCalcu->tot_cost = $sum_tot_cost;
                $sumCalcu->i_tax = $sum_i_tax;
                $sumCalcu->r_tax = $sum_r_tax;
                $sumCalcu->calcu_cost = $sum_calcu_cost;
                $sumCalcu->save();
            }

            //dd(DB::getQueryLog());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return view('errors.500');
        }


        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }


    public function exportExcel(Request $request){

        $searchFromMonth = $request->input('searchFromMonth');

        if(empty($searchFromMonth)){
            $searchFromDate = date("Y-m", time()) .'-01';
        }

        return (new ClassCalculateExport)->forYear($searchFromMonth)->download('ClassCalculateReport.xlsx');
    }

}
