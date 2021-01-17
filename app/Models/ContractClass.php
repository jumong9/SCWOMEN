<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractClass extends Model
{
    use HasFactory;


    protected $fillable = [
        'contract_id',
        'client_id',
        'class_sub_name',
        'class_day',
        'time_from',
        'time_to',
        'class_category_id',
        'class_target',
        'class_total_cost',
        'class_number',
        'class_count',
        'class_order',
        'main_count',
        'sub_count',
        'finance',
        'class_type',
        'online_type',
    ];


}
