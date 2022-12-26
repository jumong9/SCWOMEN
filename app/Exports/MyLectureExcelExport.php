<?php

namespace App\Exports;

use App\Models\ClassCategory;
use App\Models\ClassCategoryUser;
use App\Models\ClassLector;
use App\Models\ClassReport;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MyLectureExcelExport implements FromQuery, WithHeadings{


    use Exportable;

    public function forYear($searchFromDate, $searchToDate, $user_id){
        $this->searchFromDate = $searchFromDate;
        $this->searchToDate = $searchToDate;
        $this->user_id = $user_id;
        return $this;
    }

    public function query() {

        return      ContractClass::join('class_categories as b', 'b.id' ,'=', 'contract_classes.class_category_id')
                                 ->join('class_lectors as c', 'c.contract_class_id', '=','contract_classes.id')
                                 ->join('contracts as d', 'd.id', '=', 'contract_classes.contract_id')
                            //               ->join('clients as e', 'e.id', '=', 'contract_classes.client_id')
                                 ->join('common_codes as f', function($join){
                                        $join->on('f.code_id','=', 'contract_classes.class_status')
                                                ->where('f.code_group', '=','contract_class_status');
                                        }
                                    )
                                  ->select(   'contract_classes.class_day'
                                            , 'contract_classes.time_from'
                                            , 'contract_classes.time_to'
                                            , 'd.client_name'
                                            , 'b.class_name'
                                            , 'contract_classes.class_sub_name'
                                            , 'contract_classes.class_target'
                                            , 'contract_classes.class_number'
                                            , 'contract_classes.class_count'
                                            , 'contract_classes.class_order'
                                            ,  DB::raw('case when c.main_yn = 0 then  \'보조강사\' else \'주강사\' END')
                                            
                                            //, 'd.client_name'
                                            //, 'f.code_value as class_status_value'
                                            , DB::raw(
                                                        'case when contract_classes.class_type = 0 then \'오프라인\'
                                                              when contract_classes.class_type = 1 then \'온라인 실시간\'
                                                              else 
                                                                    case when contract_classes.online_type = 0 then \'온라인 동영상 - 최초방영\'
                                                                         else \'온라인 동영상 - 재방\'
                                                                    end
                                                         end as classType'
                                                    )
                                            ,  DB::raw('case when contract_classes.class_status = 0 then  \'교육예정\' else \'교육완료\' END')
                                            ,  DB::raw(
                                                ' case 
                                                                when c.main_yn = 1 then
                                                                    if((select count(*) from class_reports x where x.contract_class_id = contract_classes.id and x.user_id =  c.user_id)=1,\'작성완료\',\'미작성\')
                                                                when c.main_yn = 0 and (contract_classes.sub_finance = 2 or contract_classes.sub_finance = 3 ) then
                                                                    if((select count(*) from class_reports x where x.contract_class_id = contract_classes.id and x.user_id =  c.user_id)=1,\'작성완료\',\'미작성\')
                                                                else \'대상아님\'
                                                            end as reportCnt
                                                '
                                               )
                                               , DB::raw('DATE_FORMAT(contract_classes.created_at,"%Y-%m-%d") as dateymd')
                                    )
                                    ->where(function ($query){
                                        if(!empty($this->searchFromDate) && !empty($this->searchToDate) ){
                                            $query->whereBetween('contract_classes.class_day', [$this->searchFromDate, $this->searchToDate]);
                                        }
                                    })
                                    ->where('d.status', '>', '3')
                                    ->where('c.user_id', $this->user_id)
                                    // ->where('d.client_name','LIKE',"{$this->searchWord}%")
                                    ->orderBy('contract_classes.class_day', 'desc')
                                    ->orderBy('contract_classes.created_at', 'desc');


    }


    public function headings(): array{
        return ["활동일자", "시작시간", "종료시간", "수요처", "프로그램", "세부프로그램"
                , "교육대상", "인원", "횟수", "차수", "자격"
                , "수업방식", "진행상태", "활동일지","등록일"] ;
    }

}
