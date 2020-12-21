<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id' ,
        'board_title',
        'board_contents',
        'read_count',
        'file_id',
        'created_id',
        'created_name',
        'updated_id',
        'updated_name',
    ];

}
