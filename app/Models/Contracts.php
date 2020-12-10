<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_name',
        'name',
        'email',
        'phone',
        'phone2',
        'class_cost',
        'class_total_cost',
        'material_cost',
        'material_total_cost',
        'total_cost',
        'paid_yn',
        'status',
        'comments'
    ];
}
