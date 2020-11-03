<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memo extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['memo','user'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
