<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonCode extends Model
{
    use HasFactory;

    /**
     * return common_code
     *
     */
    public static function getCommonCode($code_group){
        return CommonCode::where('code_group','=', "{$code_group}" )
                            ->orderBy('order', 'asc')
                            ->get();
    }

}
