<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController{

    public function isAdmin(){
        //dd("grade=". Auth::user()->grade);
        if(90 > Auth::user()->grade){
            //dd(1);
            return redirect('/')->send();
        }
    }

}
