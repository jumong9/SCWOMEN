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

class LectorStatExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searchWord, $searcToDate, $searcFromDate){
        $this->searchType = $searchType;
        $this->searchWord = $searchWord;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        return $this;
    }


    public function query() {

        return User::join('class_lectors as d', 'd.user_id', '=','users.id')
                    ->join('contract_classes as e', 'e.id', '=', 'd.contract_class_id')
                    ->join('class_categories as c', 'c.id', '=','d.class_category_id')
                    ->join('class_category_user as b', function($join){
                        $join->on('b.class_category_id','=', 'd.class_category_id')
                            ->on('b.user_id', '=','d.user_id');
                        }
                    )
                    ->join('common_codes as f', function($join){
                        $join->on('f.code_id','=', 'b.user_status')
                            ->where('f.code_group', '=','user_status');
                        }
                    )
                    ->select(
                              DB::raw('if(users.gubun=0,\'내부\',\'외부\') as user_gubun')
                            , 'c.class_name'
                            , 'users.name'
                            , DB::raw('if(b.user_grade=10,\'단장\',\'일반강사\') as user_grade')
                            , 'users.birthday'
                            , 'users.mobile'
                            , 'b.user_group'
                            , 'f.code_value as user_status_value'
                            , DB::raw('sum(d.lector_cost) as lector_cost')
                            , DB::raw('sum(if(d.main_yn=1, 1, 0)) as main_count')
                            , DB::raw('sum(if(d.main_yn=0, 1, 0)) as sub_count')
                    )
                    ->where(function ($query) {
                        if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                            $query->whereBetween('e.class_day', [$this->searcFromDate, $this->searcToDate]);
                        }
                        if(!empty($this->searchWord)){
                            
                            if('name' == $this->searchType){
                                $query->where('users.name','LIKE',"{$this->searchWord}%");
                            }elseif('category' == $this->searchType){
                                $query ->where('c.class_name','LIKE', "{$this->searchWord}%");
                            }
                        }
                    })
                    ->where('e.class_status', '>', '0')
                    ->groupBy('users.name', 'users.mobile', 'users.birthday', 'user_gubun', 'user_status_value','user_grade','user_group','class_name')
                    ->orderBy('c.class_group', 'asc')
                    ->orderBy('c.class_order', 'asc');

    }

    public function headings(): array{
        return [
                  "구분"
                , "강사단명"
                , "이름"
                , "강사구분"
                , "생년월일"
                , "연락처"
                , "기수"
                , "상태"
                , "수령강사비"
                , "주강사횟수"
                , "보조횟수"
            ];
    }


}
