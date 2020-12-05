<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function hello(){
        return view('test.hello');
    }

    public function login(Request $request){

        $id = $request->input('id');
        $password = $request->input('password');
        Log::debug('Showing user profile for user: '.$id);
        Log::info('Showing user profile for user: '.$password);
        return view('test.hello')->with(['id'=> $id, 'password'=>$password]);;
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

    public function frame(){
        return view('test.frame');
    }

    public function file(){
        return view('test.file');
    }

    public function fileDO(Request $request){

        $file = $request->upload_file->store('excels');

        $url = Storage::url($file);
        echo $url;

        return $url;
    }
}


