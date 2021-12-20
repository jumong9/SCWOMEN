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

class PointStatExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searcToDate, $searcFromDate){
        $this->searchType = $searchType;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        return $this;
    }

    public function query() {
        
        return User::join('class_lectors as d', 'd.user_id', '=','users.id')
                    ->join('contract_classes as e', 'e.id', '=', 'd.contract_class_id')
                    ->select( DB::raw('max(users.name) as name') 
                            , DB::raw('max(users.mobile) as mobile')
                            , DB::raw('max(users.address) as address')
                            , DB::raw('sum(if(d.main_yn=1, 1, 0)) as main_count')
                            , DB::raw('sum(if(d.main_yn=0, 1, 0)) as sub_count')
                    )
                    ->where(function ($query) {
                        if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                            $query->whereBetween('e.class_day', [$this->searcFromDate, $this->searcToDate]);
                        }
                    })
                    ->where('e.class_status', '>', '0')
                    ->groupBy('users.id')
                    ->orderBy('name', 'asc');

    }

    public function headings(): array{
        return [
                  "강사명"
                , "연락처"
                , "거주지"
                , "주강사횟수"
                , "보조강사횟수"
            ];
    }


}
