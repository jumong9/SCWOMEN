<?php

namespace App\Exports;

use App\Models\Contracts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContractExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchWord){
        $this->searchWord = $searchWord;
        return $this;
    }


    public function query() {

        return Contracts::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'contracts.status')
                                    ->where('c.code_group', '=','contract_status');
                                }
                        )
                        ->join('clients as cl', function($join){
                                $join->on('cl.id','=', 'contracts.client_id');
                                }
                        )
                        ->select(
                                  'contracts.id'
                                , DB::raw('case when cl.gubun = 1 then  \'초등학교\'
                                                 when cl.gubun = 2 then  \'중학교\'
                                                 when cl.gubun = 3 then  \'고등학교\'
                                                 when cl.gubun = 4 then  \'돌봄\'
                                                 when cl.gubun = 5 then  \'유아\'
                                                 when cl.gubun = 6 then  \'아파트\'
                                                 else \'기타\' END')
                                , 'cl.name as client_name'
                                , 'contracts.name'
                                , 'contracts.phone'
                                , 'contracts.class_total_cost'
                                , 'contracts.material_total_cost'
                                , DB::raw('case when contracts.paid_yn = 0 then  \'미입금\' else \'입금완료\' END')
                                , 'c.code_value'
                                , DB::raw('DATE_FORMAT(contracts.created_at,"%Y-%m-%d") as dateymd')
                        )
                        ->where(function($query){
                            if(!empty($this->searchWord)){
                                $query ->where('cl.name','LIKE', "{$this->searchWord}%");
                            }
                        })
                        ->orderBy('contracts.created_at', 'desc');
    }

    public function headings(): array{
        return [
                  "계약번호"
                , "구분"
                , "수요처"
                , "담당자"
                , "연락처"
                , "총강사비"
                , "총재료비"
                , "입금상태"
                , "진행상태"
                , "등록일"];
    }

}
