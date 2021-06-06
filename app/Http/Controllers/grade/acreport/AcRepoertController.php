<?php

namespace App\Http\Controllers\grade\acreport;

use App\Http\Controllers\Controller;
use App\Models\ClassLector;
use App\Models\ClassReport;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use App\Models\UserFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcRepoertController extends Controller{


    public function __construct(){

        $this->filePath = "uploads/".date("Y")."/acreport";
        $this->pageTitle = "활동일지관리";
    }


    public function list(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        DB::enableQueryLog();
        $user_id = Auth::id();
        //echo Auth::user()->grade;

        $classList = ContractClass::join('class_categories as b', 'b.id' ,'=', 'contract_classes.class_category_id')
                                    ->join('class_lectors as c', 'c.contract_class_id', '=','contract_classes.id')
                                    ->join('contracts as d', 'd.id', '=', 'contract_classes.contract_id')
                                  //  ->join('clients as e', 'e.id', '=', 'contract_classes.client_id')
                                    ->join('class_reports as f', 'f.contract_class_id', '=', 'contract_classes.id')
                                    ->select('contract_classes.*'
                                            , 'b.class_name'
                                            , 'c.main_yn'
                                            , 'c.user_id'
                                            , 'd.client_name'
                                            , 'f.time_from as r_time_from'
                                            , 'f.time_to as r_time_to'
                                            , 'f.updated_at as r_updated_at'
                                    )
                                    ->where('d.status', '>', '3')
                                    ->where('c.user_id', $user_id)
                                    ->where('f.user_id', $user_id)
                                    ->where('d.client_name','LIKE',"{$searchWord}%")
                                    ->orderBy('contract_classes.class_day', 'desc')
                                    ->orderBy('contract_classes.created_at', 'desc')
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


        //dd(DB::getQueryLog());
        return view('grade.acreport.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

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

        $classReport = ClassReport::where('contract_class_id', $id)
                                    ->where('user_id', $user_id)->first();
        if(!empty($classReport)){
            return redirect()->route('grade.acreport.read', ['id' =>$id ]) ;
        }

        $classList = ContractClass::join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_lectors as c', 'c.contract_class_id', '=', 'contract_classes.id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            , DB::raw('case when c.main_yn = 1 then contract_classes.finance else contract_classes.sub_finance end as finance_type')
                                            )
                                    ->where('contract_classes.id',$id)
                                    ->where('c.user_id', $user_id)
                                    ->get();
//dd(DB::getQueryLog());
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
                        ->where('main_yn', 0)
                        ->orderBy('main_yn','desc')
                        ->get();




        return view('grade.acreport.create', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);

    }



    public function createDo(Request $request){

        $request->validate([
             'upload_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480'
         ]);

        $file = $request->file('upload_file');


        $user_id = Auth::id();
        $user_name = Auth::user()->name;

        $file_real_name = $file->getClientOriginalName();
        $file_extension = $file->getClientOriginalExtension();
        $file_size = $file->getSize();
        $file_mime = $file->getMimeType();
        $random_file_name = UserFile::getFileId();

        try {
            DB::beginTransaction();

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
            $file_id = UserFile::create($file_arr)->id;

            $class_id = $request->input('contract_class_id');
            $classReport = new ClassReport();
            $classReport->contract_class_id = $class_id;
            $classReport->user_id = $user_id;
            $classReport->class_category_id = $request->input('class_category_id');
            $classReport->class_day = $request->input('class_day');
            $classReport->time_from = $request->input('time_from');
            $classReport->time_to = $request->input('time_to');
            $classReport->class_place = $request->input('class_place');
            $classReport->class_contents = $request->input('class_contents');
            $classReport->class_rating = $request->input('class_rating');
            $classReport->sub_user_names = $request->input('sub_user_names');
            $classReport->finanace = $request->input('finance_type');

            $classReport->file_id = $file_id;
            $classReport->created_id = $user_id;
            $classReport->created_name = $user_name;
            $classReport->updated_id = $user_id;
            $classReport->updated_name = $user_name;
            $classReport->save();

            ContractClass::where('id',$class_id)
                            ->update([
                                'class_status'=> 2,
                            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

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
                                    ->join('class_lectors as c', 'c.contract_class_id', '=', 'contract_classes.id')
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

        // $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
        //                 ->where('contract_class_id',$id)
        //                 ->where('main_yn', 0)
        //                 ->orderBy('main_yn','desc')
        //                 ->get();

        $calssReport = ClassReport::where('contract_class_id', $id)
                                    ->where('user_id', $user_id)->first();
        $file_id = $calssReport->file_id;

        $fileInfo=null;
        if(!empty($file_id)){
            $fileInfo = UserFile::where('id', $file_id)
                              ->get();
        }

//dd(DB::getQueryLog());
        return view('grade.acreport.read', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'calssReport'=>$calssReport, 'fileInfo'=>$fileInfo, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);

    }


    public function update(Request $request){

        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $searchStatus = $request->input('searchStatus');
        $perPage = $request->input('perPage');
        $page = $request->input('page');

        $id = $request->input('id');
        $user_id = Auth::id();

        $classList = ContractClass::join('clients as b', 'b.id', '=', 'contract_classes.client_id')
                                    ->join('class_lectors as c', 'c.contract_class_id', '=', 'contract_classes.id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            , DB::raw('case when c.main_yn = 1 then contract_classes.finance else contract_classes.sub_finance end as finance_type')
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



        $calssReport = ClassReport::where('contract_class_id', $id)
                                    ->where('user_id', $user_id)->first();
        $file_id = $calssReport->file_id;

        $fileInfo=null;
        if(!empty($file_id)){
            $fileInfo = UserFile::where('id', $file_id)
                              ->get();
        }

//dd(DB::getQueryLog());
        return view('grade.acreport.update', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'calssReport'=>$calssReport, 'fileInfo'=>$fileInfo, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);

    }


    public function updateDo(Request $request){

        // $request->validate([
        //     'upload_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // ]);

        $user_id = Auth::id();
        $user_name =  Auth::user()->name;
        $file_id = $request->input('old_file_id');
        $old_file_id = $request->input('old_file_id');
        $old_file_name = $request->input('old_file_name');


        try {
            DB::beginTransaction();

            $file = $request->file('upload_file');
            if(!empty($file)){                                      //새로운 파일 업로드

                $file_real_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_mime = $file->getMimeType();
                $random_file_name = UserFile::getFileId();


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
                $file_id = UserFile::create($file_arr)->id;

                //기존파일 삭제
                //$file->delete($destinationPath, $old_file_name);
                Storage::delete($destinationPath.'/'.$old_file_name);
                UserFile::where('id',$old_file_id)->delete();
            }

            $report_id = $request->input('report_id');
            $class_id = $request->input('contract_class_id');


            ClassReport::where('id',$report_id)
                            ->update([
                                'time_from'=> $request->input('time_from'),
                                'time_to'=> $request->input('time_to'),
                                'class_place'=> $request->input('class_place'),
                                'class_contents'=> $request->input('class_contents'),
                                'class_rating'=> $request->input('class_rating'),
                                'finance'=> $request->input('finance_type'),
                                'file_id'=> $file_id,
                                'updated_id'=> $user_id,
                                'updated_name'=> $user_name,
                                'sub_user_names'=> $request->input('sub_user_names'),
                            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

        return redirect()->route('grade.acreport.read', ['pageTitle'=>$this->pageTitle,'id' =>$class_id ]) ;
    }


}
