<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassSumExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searcToDate, $searcFromDate){
        $this->searchType = $searchType;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        return $this;
    }

    public function query() {

        return ContractClass::join('class_categories as b', 'contract_classes.class_category_id' ,'=', 'b.id')
                            ->join('clients as c', 'contract_classes.client_id' ,'=', 'c.id')
                            ->join('common_codes as d', function($join){
                                $join->on('d.code_id','=', 'c.gubun')
                                    ->where('d.code_group', '=','client_gubun');
                                }
                            )
                            ->join('class_lectors as e', 'contract_classes.id', '=','e.contract_class_id')
                            ->select('b.class_gubun'
                                    , 'b.class_name'
                                    , 'd.code_value'
                                    , 'c.name'
                                    , DB::raw('sum(contract_classes.class_count) as class_count')
                                    , DB::raw('sum(contract_classes.class_order) as class_order')
                                    , DB::raw('sum(contract_classes.main_count + contract_classes.sub_count) as lector_count')
                                    , DB::raw('sum(e.lector_cost) as lector_cost')
                                    , DB::raw('sum(if(contract_classes.class_type=0,1,0)) as off_count')
                                    , DB::raw('sum(if(contract_classes.class_type=1,1,0)) as on_count')
                                    , DB::raw('sum(if(contract_classes.class_type=2,1,0)) as video_count')
                            )
                            ->where(function ($query) {
                                if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                                    $query->whereBetween('contract_classes.class_day', [$this->searcFromDate, $this->searcToDate]);
                                }
                            })
                            ->where('contract_classes.class_status', '>', '0')
                            ->groupBy('b.class_gubun'
                                    , 'b.class_name'
                                    , 'c.name'
                                    , 'd.code_value')
                            ->orderBy('b.class_group', 'asc')
                            ->orderBy('b.class_order', 'asc')
                            ->orderBy('d.code_id', 'asc')
                            ->orderBy('c.name', 'asc');

    }

    public function headings(): array{
        return [
                  "구분"
                , "강사단명"
                , "수요처구분"
                , "수요처명"
                , "진행횟수"
                , "진행차시"
                , "진행인원"
                , "강사비 지출금액"
                , "오프라인"
                , "온라인"
                , "온라인동영상"
            ];
    }


}
