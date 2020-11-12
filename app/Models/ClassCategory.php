<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCategory extends Model
{
    use HasFactory;

    public $fillable = ['calss_gubun','class_name'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
