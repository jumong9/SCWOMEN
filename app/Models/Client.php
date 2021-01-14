<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gubun',
        'client_tel',
        'client_fax',
        'client_loctype',
        'client_loctype_etc',
        'office_tel',
        'office_fax',
        'office_email',
        'zipcode',
        'address',
    ];

}
