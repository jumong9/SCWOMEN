<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function hello(){
        return view('test.hello');
    }

    public function main(){
        $books = ['Jacson', 'Laravel'];
        //return view('test.main',['books'=> $books ]);
        //return view('test.main')->withBooks( $books );
        return view('test.main')->with([ 'books'=> $books ]);
    }

    public function bye(){
        return view('test.bye');
    }

    public function project(){
        $projects = \App\Models\Project::all();
        return view('test.project')->with([ 'projects'=> $projects ]);
    }
}

    
