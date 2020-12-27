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

                        ->select(
                            'c.code_value as client_gubun_value',
                            'clients.name',

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

                , "대표전화"
                , "대표팩스"
                , "행정실전화"
                , "행정실팩스", "우편번호", "주소"];
    }


}
