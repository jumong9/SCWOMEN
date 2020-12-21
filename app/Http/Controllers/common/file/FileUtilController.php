<?php

namespace App\Http\Controllers\common\file;

use App\Http\Controllers\Controller;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileUtilController extends Controller
{


    public function fileDown(Request $request){
        DB::enableQueryLog();
        $file_id = $request->input('file_id');
        $fileInfo = UserFile::where('file_name','=', $file_id)->first();

        //dd(DB::getQueryLog());

        $headers =['Content-Type', $fileInfo->file_mime] ;

        return Storage::download($fileInfo->file_path.'/'.$file_id, $fileInfo->file_real_name, $headers);



		// return (new Response($file, 200))
        //       ->header('Content-Type', $fileInfo->file_mime)
        //       ->header('filename', $fileInfo->file_real_name )
        //       ;

    }

}
