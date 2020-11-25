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
        'class_type'
    ];


}
