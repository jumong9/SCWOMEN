<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_class_id',
        'user_id',
        'class_category_id',
        'class_day',
        'time_from',
        'time_to',
        'class_place',
        'class_contents',
        'class_rating',
    ];


}
