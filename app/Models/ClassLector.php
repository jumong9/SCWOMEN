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
        'main_yn',
        'main_count',
        'sub_count',
    ];

}

