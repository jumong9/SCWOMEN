<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdMemberExport implements FromQuery, WithHeadings{


    use Exportable;

    public function forSearch($searchType, $searchGrade, $searchWord, $searchStatus){
        $this->searchType = $searchType;
        $this->searchGrade = $searchGrade;
        $this->searchWord = $searchWord;
        $this->searchStatus = $searchStatus;

        return $this;
    }

    public function query() {


        return      User::join('class_category_user', 'users.id' ,'=', 'class_category_user.user_id')
                        ->join('class_categories', 'class_category_user.class_category_id', '=', 'class_categories.id')
                        ->select(
                                  DB::raw('case when users.gubun = 0 then  \'내부\' else \'외부\' END')
                                , 'class_category_user.user_group'
                                , 'users.name'
                                , 'class_categories.class_name'
                                , DB::raw('case when class_category_user.user_grade = 0 then  \'일반강사\' else \'반장강사\' END')
                                , 'class_category_user.main_count'
                                , 'class_category_user.sub_count'
                                , 'users.mobile'
                                , 'users.email'
                                , DB::raw('case when class_category_user.user_status = 0 then  \'승인대기\'
                                                when class_category_user.user_status = 2 then  \'활동중\'
                                                when class_category_user.user_status = 4 then  \'프리랜서\'
                                                when class_category_user.user_status = 6 then  \'활동보류\'
                                                when class_category_user.user_status = 8 then  \'활동중단\'
                                                else \'\' END')
                                , 'class_category_user.joinday'
                        )
                        ->where('users.grade', '<', 90)
                        ->where(function($query){
                            if($this->searchStatus!=99){
                                $query->where('class_category_user.user_status', "{$this->searchStatus}");
                            }else{
                                $query->where('class_category_user.user_status', '>', 0);
                            }
                            if("" != $this->searchGrade){
                                $query->where('class_category_user.user_grade', "{$this->searchGrade}");
                            }
                            if(!empty($this->searchWord)){
                                if('name'==$this->searchType) {
                                    $query ->where('users.name','LIKE',"{$this->searchWord}%");
                                }elseif('group'==$this->searchType){
                                    $query ->where('class_category_user.user_group', "{$this->searchWord}");
                                }elseif('category'==$this->searchType){
                                    $query ->where('class_categories.class_name','LIKE', "{$this->searchWord}%");
                                }
                            }
                        })
                        ->orderBy('users.created_at', 'desc');

    }


    public function headings(): array{
        return ["구분", "기수", "강사명", "강사단명", "등급"
                , "주강사", "보조강사", "핸드폰", "E-mail", "상태"
                , "입단일"] ;
    }

}
