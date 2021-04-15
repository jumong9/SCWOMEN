<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassLector extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'class_category_id',
        'sub_user_names',
        'main_yn',
        'main_count',
        'sub_count',
        'lector_cost',
        'lector_main_count',
        'lectro_main_cost',
        'lector_extra_count',
        'lector_extra_cost',
    ];

}

