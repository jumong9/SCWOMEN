<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function main(){
        $books = ['Jacson', 'Laravel'];
        return view('users.main')->with([ 'books'=> $books ]);

    }

}


