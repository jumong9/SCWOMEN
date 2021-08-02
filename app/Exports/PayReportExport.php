<?php

namespace App\Exports;

use App\Models\ContractClass;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

//강사비 지급대상 엑셀다운
class PayReportExport implements FromQuery, WithHeadings{

    use Exportable;

    public function forYear($searcFromDate, $searcToDate)
    {
        $this->searcFromDate = $searcFromDate;
        $this->searcToDate = $searcToDate;

        return $this;
    }



    public function query() {

        return ContractClass::join('class_categories as b', 'b.id' ,'=', 'contract_classes.class_category_id')
                                    ->join('class_lectors as c', 'c.contract_class_id', '=','contract_classes.id')
                                    ->join('contracts as d', 'd.id', '=', 'contract_classes.contract_id')
                                    ->join('users as e', 'e.id', '=', 'c.user_id')
                                    ->join('common_codes as f', function($join){
                                        $join->on('f.code_id','=', 'contract_classes.class_status')
                                                ->where('f.code_group', '=','contract_class_status');
                                        }
                                    )
                                    ->leftjoin('common_codes as f2', function($join){
                                        $join->on(DB::raw('case when c.main_yn = 1 then f2.code_id = contract_classes.finance else f2.code_id = contract_classes.sub_finance end'), DB::raw('1=1'))
                                            ->where('f2.code_group', '=',"finance_type");
                                     //   $join->on('f2.code_id','=', 'contract_classes.finance');
                                    })
                                    ->select(
                                               'e.name'
                                            ,  'contract_classes.class_day'
                                            ,  'contract_classes.time_from'
                                            ,  'contract_classes.time_to'
                                            ,  DB::raw('case when c.main_yn = 1 then \'주강사\' else \'보조강사\' END')
                                            ,  DB::raw('case when c.main_yn = 1 then c.main_count else c.sub_count END')
                                            ,  'contract_classes.class_count'
                                            ,  'contract_classes.class_order'
                                            , 'c.lector_cost'
                                            , 'c.lector_cost as tot'
                                            , DB::raw('round(c.lector_cost * 0.03) AS i_tax')
                                            , DB::raw('round(c.lector_cost * 0.003) AS r_tax')
                                            , DB::raw('c.lector_cost - round(c.lector_cost * 0.033) AS pay')
                                            , 'd.client_name'
                                            , 'b.class_gubun'
                                            , 'b.class_name'
                                         //   , 'f.code_value as class_status_value'
                                            , DB::raw('case when contract_classes.class_status = 2 then \'작성완료\' else \'\' END')
                                            , 'f2.code_value as finance_value'
                                    )
                                    ->where('contract_classes.class_status', '>', '0')
                                    ->whereBetween('contract_classes.class_day', [$this->searcFromDate, $this->searcToDate])
                                    ->orderBy('e.name', 'asc')
                                    ->orderBy('e.id', 'asc')
                                    ->orderBy('contract_classes.class_day', 'asc')
                                    ->orderBy('contract_classes.time_from', 'asc');
                                //    ->orderBy('contract_classes.updated_at', 'desc')
                                //    ->groupBy(DB::raw('e.id with rollup'))
                                //    ->download('PayReport.xlsx');

    }

    public function headings(): array{
        return ["강사명", "강의일", "시작시간", "종료시간", "강사구분", "지급기준", "횟수", "차수", "강사비", "총액", "소득세", "주민세", "실지급액", "수요처","분류", "프로그램", "활동일지", "재원"];
    }

}
