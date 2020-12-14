<?php

namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExcelExport implements FromQuery, WithHeadings {


    use Exportable;

    public function forYear($searcFromDate, $searcToDate)
    {
        $this->searcFromDate = $searcFromDate;
        $this->searcToDate = $searcToDate;

        return $this;
    }


    public function query() {

        return User::get();

    }

    public function headings(): array{
        return ["강사명", "강의일", "시작시간", "종료시간", "강사구분", "지급기준", "횟수", "차수", "총액", "소득세", "주민세", "실지급액", "수요처", "프로그램", "진행상태"];
    }

}
