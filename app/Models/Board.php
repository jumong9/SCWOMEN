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
        'important_yn',
        'read_count',
        'file_id',
        'file_id2',
        'created_id',
        'created_name',
        'updated_id',
        'updated_name',
    ];

}
