<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\User;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LectorSumExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searcToDate, $searcFromDate){
        $this->searchType = $searchType;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        return $this;
    }

    public function query() {

        return User::join('class_lectors as b', 'b.user_id' ,'=', 'users.id')
                    ->join('contract_classes as c', 'c.id', '=', 'b.contract_class_id')
                    ->join('class_categories as d', 'd.id', '=','b.class_category_id')
                            
                            ->select( 
                                      'users.name'
                                    , 'users.mobile'
                                    , 'd.class_gubun'
                                    , 'd.class_name'
                                    , DB::raw('sum(if(b.main_yn=1, 1, 0)) as main_count')
                                    , DB::raw('sum(if(b.main_yn=0, 1, 0)) as sub_count')
                                    , DB::raw('sum(b.lector_cost) as lector_cost')
                                    , DB::raw('count(distinct c.client_id) as client_count')
                            )

                            ->where(function ($query) {
                                if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                                    $query->whereBetween('c.class_day', [$this->searcFromDate, $this->searcToDate]);
                                }
                            })
                            ->where('c.class_status', '>', '0')
                            ->groupBy('users.id', 'users.name', 'users.mobile', 'd.class_gubun', 'd.class_name')
                            ->orderBy('users.name', 'asc')
                            ->orderBy('users.id', 'asc');

    }

    public function headings(): array{
        return [
                  "이름"
                , "연락처"
                , "구분"
                , "강사단명"
                , "주강사횟수"
                , "보조횟수"
                , "강사비 지출금액"
                , "수요처수"
            ];
    }


}
