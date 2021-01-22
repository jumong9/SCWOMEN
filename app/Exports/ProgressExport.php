<?php

namespace App\Exports;

use App\Models\ContractClass;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

//강의 진행관리 엑셀다운
class ProgressExport implements FromQuery, WithHeadings{

    use Exportable;

    public function forYear($searcFromDate, $searcToDate, $searchType, $searchWord)
    {
        $this->searcFromDate = $searcFromDate;
        $this->searcToDate = $searcToDate;
        $this->searchType = $searchType;
        $this->searchWord = $searchWord;

        return $this;
    }

    public function query() {

        return ContractClass::join('contracts', 'contracts.id', '=','contract_classes.contract_id')
                            ->join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                            ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                            ->select(
                                      'contracts.id'
                                    , 'contract_classes.class_day'
                                    , 'contract_classes.time_from'
                                    , 'contract_classes.time_to'
                                    , 'contracts.client_name'
                                    , 'd.class_gubun'
                                    , 'd.class_name'
                                    , 'contract_classes.class_target'
                                    , 'contract_classes.class_number'
                                    , 'contract_classes.class_count'
                                    , 'contract_classes.class_order'
                                    , 'contract_classes.main_count'
                                    , 'contract_classes.sub_count'
                                    , DB::raw('case when contract_classes.lector_apply_yn = 0 then \'배정중\' else \'배정완료\' END')
                                    , DB::raw('case when contract_classes.class_status = 0 then \'수업예정\' else \'수업완료\' END')
                                    , DB::raw('case when contract_classes.class_status = 2 then  \'작성완료\' else \'미작성\' END')

                            )
                            ->where('contracts.status','>',1)
                            ->whereBetween('contract_classes.class_day', [$this->searcFromDate, $this->searcToDate])
                            ->where(function($query){
                                if(!empty($this->searchWord)){
                                    if('contract_id'== $this->searchType) {
                                        $query->where('contracts.id', "{$this->searchWord}");
                                    }elseif('client_name'==$this->searchType) {
                                        $query->where('b.name', 'LIKE', "{$this->searchWord}%");
                                    }
                                }
                            })
                            ->orderBy('contract_classes.created_at', 'desc');


    }

    public function headings(): array{
        return ["계약번호", "활동일자", "시작시간", "종료시간", "수요처", "분야", "프로그램", "교육대상", "인원", "횟수", "차수", "주강사", "보조강사", "배정", "수업", "활동일지"];
    }

}
