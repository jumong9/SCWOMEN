<?php

namespace App\Http\Controllers\management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManagementController extends Controller
{

    public function main(){
        $books = ['Jacson', 'Laravel'];
        return view('management.main')->with([ 'books'=> $books ]);
    }


}


