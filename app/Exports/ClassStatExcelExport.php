<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassStatExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searcToDate, $searcFromDate){
        $this->searchType = $searchType;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        return $this;
    }

    public function query() {

        return ContractClass::join('class_categories as c', 'contract_classes.class_category_id', '=', 'c.id')
                                ->select( 'c.class_gubun'
                                        , 'c.class_name'
                                        , DB::raw('sum(contract_classes.main_count) as main_count')
                                        , DB::raw('sum(contract_classes.sub_count) as sub_count')
                                )
                                ->where(function ($query){
                                    if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                                        $query->whereBetween('contract_classes.class_day', [$this->searcFromDate, $this->searcToDate]);
                                    }
                                })
                                ->where('contract_classes.class_status', '>', '0')
                                ->groupBy('c.id', 'c.class_name','c.class_gubun')
                                ->orderBy('c.class_group', 'asc')
                                ->orderBy('c.class_order', 'asc');

    }

    public function headings(): array{
        return [
                  "분류"
                , "강사단명"
                , "주강사 파견실적"
                , "보조강사 파견실적"
            ];
    }


}
