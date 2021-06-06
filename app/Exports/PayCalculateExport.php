<?php

namespace App\Exports;

use App\Models\ClassCalculate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayCalculateExport implements FromQuery, WithHeadings{


    use Exportable;

    public function forYear($searchFromMonth, $financeType){
        $this->searchFromMonth = $searchFromMonth;
        $this->financeType = $financeType;
        return $this;
    }


    public function query() {

        return ClassCalculate::leftjoin('common_codes as c1', function($join){
                                    $join->on('c1.code_id','=', 'class_calculates.finance')
                                        ->where('c1.code_group', '=','finance_type');
                                    }
                                )
                              ->where('calcu_month', $this->searchFromMonth)
                              ->where('finance', $this->financeType)
                              ->select(
                                          'user_name'
                                        , 'class_day'
                                        , DB::raw('lector_main_count+lector_extra_count')
                                        , DB::raw('case when user_name is null and class_day is null then \'총합계\'
                                                        when class_day is null then \'소계\'
                                                        else case when main_yn = 1 then \'주강사\' else \'보조강사\' end
                                                    end' )
                                        , DB::raw('case when main_yn = 1 then my_main_count else my_sub_count end')
                                        , 'lector_main_count'
                                        , 'lector_main_cost'
                                        , 'lector_extra_count'
                                        , 'lector_extra_cost'
                                        , 'tot_cost'
                                        , 'i_tax'
                                        , 'r_tax'
                                        , 'calcu_cost'
                                        , DB::raw('case when class_day is null then \'\'
                                                        else
                                                                case when class_type = 0 then \'오프라인\'
                                                                when class_type = 1 then \'온라인실시간\'
                                                                else case when online_type = 0 then \'온라인동영상-최초방영\' else \'온라인동영상-재방\' end
                                                                end
                                                    end' )
                                        , 'client_name'
                                        , DB::raw('concat(class_gubun,\' - \',class_name)')
                                        , 'c1.code_value'


                              )
                              ->orderByRaw('ISNULL(user_name), user_name ASC')
                              ->orderBy('main_yn', 'desc')
                              ->orderByRaw('ISNULL(class_day), class_day ASC')
                              ->orderBy('my_main_count', 'asc');
    }

    public function headings(): array{
        return ["강사명", "활동일자", "시간", "자격", "지급기준"
                , "기본시간", "기본금액", "추가시간", "추가금액"
                , "총액", "소득세","주민세", "실지급액"
                , "강의방식", "수요처", "프로그램","재원"] ;
    }
}
