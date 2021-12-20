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

class PointDetailStatExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function forSearch($searchType, $searcToDate, $searcFromDate, $id){
        $this->searchType = $searchType;
        $this->searcToDate = $searcToDate;
        $this->searcFromDate = $searcFromDate;
        $this->id = $id;
        return $this;
    }

    public function query() {
        
        return User::join('class_lectors as b', 'b.user_id', '=','users.id')
                    ->join('contract_classes as c', 'c.id', '=', 'b.contract_class_id')
                    ->join('clients as d', 'd.id', '=', 'c.client_id')
                    ->join('common_codes as e', 'd.client_loctype', '=', 'e.code_id')
                    ->join('class_categories as f', 'f.id', '=', 'b.class_category_id')
                    ->select( 'users.name'
                            , 'c.class_day'
                            , DB::raw('if(b.main_yn=1, \'주강사\', \'보조강사\') as main_yn')
                            , 'd.name as client_name'
                            , 'f.class_name'
                            , 'e.code_value'
                    )
                    ->where(function ($query){
                        if(!empty($this->searcFromDate) && !empty($this->searcToDate) ){
                            $query->whereBetween('c.class_day', [$this->searcFromDate, $this->searcToDate]);
                        }
                    })
                    ->where('c.class_status', '>', '0')
                    ->where('e.code_group', '=', 'client_loctype')
                    ->where('users.id',$this->id);

    }

    public function headings(): array{
        return [
                  "강사명"
                , "활동일자"
                , "자격"
                , "수요처"
                , "프로그램"
                , "지역구"
            ];
    }


}
