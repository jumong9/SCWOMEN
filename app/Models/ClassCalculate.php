<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCalculate extends Model
{
    use HasFactory;


    protected $fillable = [
        'calcu_month',
        'contract_id',
        'client_id',
        'clinet_name',
        'contract_class_id',
        'class_gubun',
        'class_name',
        'class_sub_name',
        'class_day',
        'class_count',
        'class_order',
        'class_type',
        'online_type',
        'main_yn',
        'lector_cost',
        'extra_cost',
        'my_main_count',
        'my_sub_count',
        'user_id',
        'uesr_name',
        'tot_cost',
        'i_tax',
        'r_tax',
        'calcu_cost',
    ];


}
