<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

}
