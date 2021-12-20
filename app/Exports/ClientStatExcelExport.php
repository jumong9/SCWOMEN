<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientStatExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searcToDate, $searcFromDate){
        $this->searchType = $searchType;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        return $this;
    }

    public function query() {

        return Client::join('contract_classes as c', 'c.client_id' ,'=', 'clients.id')
                        ->join('class_lectors as d', 'c.id', '=','d.contract_class_id')
                        ->join('common_codes as e', function($join){
                            $join->on('e.code_id','=', 'clients.gubun')
                                ->where('e.code_group', '=','client_gubun');
                            }
                        )
                        ->select( 
                                  'e.code_value as client_gubun_value'
                                , 'clients.name'
                                , DB::raw('sum(c.class_number) as class_number')
                            //    , 'c.class_status'
                                , DB::raw('count(d.id) as lector_count')
                                , DB::raw('sum(d.lector_cost) as lector_cost')
                        )
                        ->where(function ($query) {
                            if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                                $query->whereBetween('c.class_day', [$this->searcFromDate, $this->searcToDate]);
                            }
                            if(!empty($this->searchType)){
                                $query->where('clients.gubun','=',"{$this->searchType}");
                            }
                        })
                        ->where('c.class_status', '>', '0')
                        ->groupBy('clients.id','clients.name','clients.gubun','e.code_value')
                        ->orderBy('clients.id', 'asc');

    }

    public function headings(): array{
        return [
                  "구분"
                , "수요처명"
                , "수업인원"
                , "강사인원"
                , "강사비용"
            ];
    }


}
