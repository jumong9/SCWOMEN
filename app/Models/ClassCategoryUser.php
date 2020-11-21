<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCategoryUser extends Model
{
    use HasFactory;

    protected $table = 'class_category_user';

    public $fillable = ['class_category_id','user_id'];


}
