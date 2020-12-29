<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientExcelExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function query() {
       // DB::enableQueryLog();
        //return Client::get();
        return Client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                    ->where('c.code_group', '=','client_gubun');
                                }
                            )
                        ->join('common_codes as cc', function($join){
                                $join->on('cc.code_id','=', 'clients.client_loctype')
                                    ->where('cc.code_group', '=','client_loctype');
                                }
                            )
                        ->select(
                            'c.code_value as client_gubun_value',
                            'clients.name',
                            'cc.code_value as client_loctype_value',
                            'clients.client_tel',
                            'clients.client_fax',
                            'clients.office_tel',
                            'clients.office_fax',
                            'clients.zipcode',
                            'clients.address',
                            )
                        ->orderBy('clients.created_at','desc');

    }

    public function headings(): array{
        return [
                  "구분"
                , "수요처명"
                , "지역구분"
                , "대표전화"
                , "대표팩스"
                , "행정실전화"
                , "행정실팩스"
                , "우편번호"
                , "주소"];
    }


}
