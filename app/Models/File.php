<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_real_name',
        'file_path',
        'file_extension',
        'file_size',
        'file_mime',
        'user_id',
    ];


    public static function getFileId(){

        $Length = 30;
        $RandomString = substr(str_shuffle(md5(time())), 0, $Length);
        return $RandomString;
    }

}
