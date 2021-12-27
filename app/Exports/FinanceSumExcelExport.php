<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinanceSumExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searcToDate, $searcFromDate){
        $this->searchType = $searchType;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        return $this;
    }

    public function query() {

        return ContractClass::join('class_categories as c', 'contract_classes.class_category_id' ,'=', 'c.id')
                            ->join('common_codes as b', function($join){
                                $join->on('b.code_id','=', 'contract_classes.finance')
                                ->where('b.code_group', '=','finance_type');
                                }
                            )
                            ->join('class_lectors as d', 'contract_classes.id', '=','d.contract_class_id')
                            ->select( 'b.code_value'
                                    , 'c.class_gubun'
                                    , 'c.class_name'
                                    , DB::raw('sum(contract_classes.class_count) as class_count')
                                    , DB::raw('sum(contract_classes.class_order) as class_order')
                                    , DB::raw('sum(contract_classes.main_count + contract_classes.sub_count) as lector_count')
                                    , DB::raw('sum(d.lector_cost) as lector_cost')
                            )
                            ->where(function ($query){
                                if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                                    $query->whereBetween('contract_classes.class_day', [$this->searcFromDate, $this->searcToDate]);
                                }
                            })
                            ->where('contract_classes.class_status', '>', '0')
                            ->groupBy('b.code_value'
                                    , 'c.class_gubun'
                                    , 'c.class_name')
                            ->orderBy('contract_classes.finance', 'asc')
                            ->orderBy('c.class_group', 'asc')
                            ->orderBy('c.class_order', 'asc');

    }

    public function headings(): array{
        return [
                  "재원"
                , "구분"
                , "강사단명"
                , "진행횟수"
                , "진행차시"
                , "진행인원"
                , "지출금액"
            ];
    }


}
