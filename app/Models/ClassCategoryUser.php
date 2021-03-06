<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCategoryUser extends Model
{
    use HasFactory;

    protected $table = 'class_category_user';

    public $fillable = ['class_category_id'
                        ,'user_id'
                        ,'user_grade'
                        ,'user_status'
                        ,'main_count'
                        ,'sub_count'
                        ,'joinday'
                        ,'stopday'
                        ,'user_group'];


}
