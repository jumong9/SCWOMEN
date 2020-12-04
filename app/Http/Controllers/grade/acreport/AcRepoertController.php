<?php

namespace App\Http\Controllers\grade\acreport;

use App\Http\Controllers\Controller;
use App\Models\ClassLector;
use App\Models\ClassReport;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcRepoertController extends Controller{


    public function __construct(){

        $this->filePath = "uploads/".date("Y")."/acreport";
        $this->pageTitle = "활동일지관리";
    }



    public function create(Request $request){

        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');

        $id = $request->input('id');
        $user_id = Auth::id();

        $classList = ContractClass::join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_category_user as c', 'c.class_category_id', '=', 'contract_classes.class_category_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            )
                                    ->where('contract_classes.id',$id)
                                    ->where('c.user_id', $user_id)
                                    ->get();

        $contract = Contracts::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'contracts.status')
                                            ->where('c.code_group', '=','contract_status');
                                    }
                                )->where('contracts.id',$classList[0]->contract_id)
                                ->get();


        $contract[0]->id=$id;

        $client = Client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                     ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $contract[0]->client_id)
                            ->get();

        $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
                        ->where('contract_class_id',$id)
                        ->orderBy('main_yn','desc')
                        ->get();

//dd(DB::getQueryLog());
        return view('grade.acreport.create', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);

    }



    public function createDo(Request $request){

        $file = $request->file('upload_file');


        $user_id = Auth::id();
        $file_real_name = $file->getClientOriginalName();
        $file_extension = $file->getClientOriginalExtension();
        $file_size = $file->getSize();
        $file_mime = $file->getMimeType();
        $random_file_name = File::getFileId();


        //Move Uploaded File
        $destinationPath = $this->filePath;
        $file->move($destinationPath, $random_file_name);

        $file_arr = [
            "file_name"             =>  $random_file_name,
            "file_path"             =>  $destinationPath,
            "file_real_name"        =>  $file_real_name,
            "file_extension"        =>  $file_extension,
            "file_size"             =>  $file_size,
            "file_mime"             =>  $file_mime,
            "user_id"               =>  $user_id,
        ];
        $file_id = File::create($file_arr)->id;

        $class_id = $request->input('conatract_class_id');
        $classReport = new ClassReport();
        $classReport->conatract_class_id = $class_id;
        $classReport->user_id = $user_id;
        $classReport->class_category_id = $request->input('class_category_id');
        $classReport->class_day = $request->input('class_day');
        $classReport->time_from = $request->input('time_from');
        $classReport->time_to = $request->input('time_to');
        $classReport->class_place = $request->input('class_place');
        $classReport->class_contents = $request->input('class_contents');
        $classReport->class_rating = $request->input('class_rating');
        $classReport->file_id = $file_id;
        $classReport->save();


        return redirect()->route('grade.acreport.read', ['pageTitle'=>$this->pageTitle,'id' =>$class_id ]) ;
    }


    public function read(Request $request){

        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');

        $id = $request->input('id');
        $user_id = Auth::id();

        $classList = ContractClass::join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_category_user as c', 'c.class_category_id', '=', 'contract_classes.class_category_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            )
                                    ->where('contract_classes.id',$id)
                                    ->where('c.user_id', $user_id)
                                    ->get();

        $contract = Contracts::join('common_codes as c', function($join){
                                    $join->on('c.code_id','=', 'contracts.status')
                                            ->where('c.code_group', '=','contract_status');
                                    }
                                )->where('contracts.id',$classList[0]->contract_id)
                                ->get();


        $contract[0]->id=$id;

        $client = Client::join('common_codes as c', function($join){
                                $join->on('c.code_id','=', 'clients.gubun')
                                     ->where('c.code_group', '=','client_gubun');
                                }
                            )
                            ->where('clients.id', $contract[0]->client_id)
                            ->get();

        $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
                        ->where('contract_class_id',$id)
                        ->orderBy('main_yn','desc')
                        ->get();

        $calssReport = ClassReport::where('id', $id)->get();

//dd(DB::getQueryLog());
        return view('grade.acreport.read', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'calssReport'=>$calssReport, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);

    }

}
