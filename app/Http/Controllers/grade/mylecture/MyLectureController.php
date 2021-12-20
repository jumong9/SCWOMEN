<?php

namespace App\Http\Controllers\grade\mylecture;

use App\Http\Controllers\Controller;
use App\Models\ClassCategory;
use App\Models\ClassCategoryUser;
use App\Models\ClassLector;
use App\Models\ClassReport;
use App\Models\Client;
use App\Models\ContractClass;
use App\Models\Contracts;
use App\Models\UserFile;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MyLectureController extends Controller{

    public $pageTitle;

    public function __construct(){
        $this->pageTitle = "나의 강좌 관리";
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
                     //               ->join('clients as e', 'e.id', '=', 'contract_classes.client_id')
                                    ->join('common_codes as f', function($join){
                                        $join->on('f.code_id','=', 'contract_classes.class_status')
                                                ->where('f.code_group', '=','contract_class_status');
                                        }
                                    )
                                    ->select('contract_classes.*'
                                            , 'b.class_name'
                                            , 'c.main_yn'
                                            , 'c.user_id'
                                            , 'd.client_name'
                                            , 'f.code_value as class_status_value'
                                            , DB::raw(
                                                        'case when c.main_yn = 1 then
                                                            (select count(*) from class_reports x where x.contract_class_id = contract_classes.id and x.user_id =  c.user_id)
                                                              when c.main_yn = 0 and (contract_classes.sub_finance = 2 or contract_classes.sub_finance = 3 ) then
                                                            (select count(*) from class_reports x where x.contract_class_id = contract_classes.id and x.user_id =  c.user_id)
                                                              else 99
                                                         end as reportCnt'
                                                    )
                                    )
                                    ->where('d.status', '>', '3')
                                    ->where('c.user_id', $user_id)
                                    ->where('d.client_name','LIKE',"{$searchWord}%")
                                    ->orderBy('contract_classes.class_day', 'desc')
                                    ->orderBy('contract_classes.created_at', 'desc')
                                    ->paginate($perPage);


        $classList->appends (array ('perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'searchStatus'=>$searchStatus));


 //       dd(DB::getQueryLog());
        return view('grade.mylecture.list', ['pageTitle'=>$this->pageTitle,'classList'=>$classList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus] );

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
                                    ->join('common_codes as f', function($join){
                                        $join->on('f.code_id','=', 'contract_classes.class_status')
                                                ->where('f.code_group', '=','contract_class_status');
                                        }
                                    )
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            , 'f.code_value as class_status_value'
                                            , 'c.main_yn as mainYn'
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
        //                             ->where('contract_class_id',$id)
        //                             ->orderBy('main_yn','desc')
        //                             ->get();

        $lectorsList = ClassLector::join('users as b', 'b.id', '=', 'class_lectors.user_id')
                                    ->join('contract_classes as d', 'd.id', '=', 'class_lectors.contract_class_id')
                                    ->join('class_category_user as c', function($join){
                                          $join->on('c.user_id', '=', 'class_lectors.user_id');
                                          $join->on('c.class_category_id' ,'=', 'class_lectors.class_category_id');
                                          }
                                    )
                                    ->where('contract_class_id',$id)
                                    ->orderBy('main_yn','desc')
                                    ->get();
//dd(DB::getQueryLog());
        $mainYn = ClassLector::where('contract_class_id',$id)
                                ->where('user_id', $user_id)
                                ->where('main_yn', 1)->first();

        $today = strtotime(date('Y-m-d'));
        $target = strtotime($classList[0]->class_day);

        $timeDiff = 0;
        if($today >= $target) {
            $timeDiff = 1;
        }
        $reportNeedYn = 0;

        if($timeDiff){

            $classReport = ClassReport::where('contract_class_id', $id)
                                      ->where('user_id', $user_id)->first();
            if(empty($classReport)){
                $reportNeedYn = 1;
            }

            if(empty($mainYn)){
                if( $classList[0]->sub_finance != 2 && $classList[0]->sub_finance != 3 ){      //서울시성평등(2), 성평등(3) 인경우 보조강사도 리포트작성
                    $reportNeedYn = 0;
                }
            }
        }

   //     echo($timeDiff);
   //     echo($reportNeedYn);


        return view('grade.mylecture.read', ['timeDiff' =>$timeDiff, 'reportNeedYn'=>$reportNeedYn, 'pageTitle'=>$this->pageTitle, 'mainYn'=>$mainYn, 'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
        //return "ok";
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
                                    ->join('class_category_user as c', 'c.class_category_id', '=', 'contract_classes.class_category_id')
                                    ->join('class_categories as d', 'd.id' ,'=', 'contract_classes.class_category_id')
                                    ->join('common_codes as f', function($join){
                                        $join->on('f.code_id','=', 'contract_classes.class_status')
                                                ->where('f.code_group', '=','contract_class_status');
                                        }
                                    )
                                    ->select('contract_classes.*'
                                            , 'b.name as client_name'
                                            , 'd.class_name'
                                            , 'd.class_gubun'
                                            , 'f.code_value as class_status_value'
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
        return view('grade.mylecture.update', ['pageTitle'=>$this->pageTitle,'client'=>$client[0], 'contract'=>$contract[0], 'contentsList'=>$classList, 'lectorsList'=>$lectorsList, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page, 'searchStatus'=>$searchStatus]);
        //return "ok";
    }


    public function updateDo(Request $request){

        $id = $request->input('id');
        $class_status = $request->input('class_status');
        $class_type = $request->input('class_type');
        $online_type = $request->input('online_type');
        $material_cost = $request->input('material_cost');

        if(!ClassLector::where('contract_class_id',$id)
                        ->where('user_id',  Auth::id())
                        ->first()){
            return response()->json(['msg'=>'잘못된 접근입니다.']);
        }


        ContractClass::where('id',$id)
                        ->update([
         //                   'class_status'=> $class_status,
                            'class_type'=> $class_type,
                            'online_type'=> $online_type,
                            'material_cost'=>$material_cost,
                        ]);

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }


    public function updateClassReset(Request $request){

        $id = $request->input('id');
        $class_status = $request->input('class_status');

        try {
            DB::beginTransaction();

            ContractClass::where('id',$id)
                         ->update([
                                'class_status'=>$class_status
                            ]);

            $contractClass = ContractClass::where('id',$id)->get();
            //$class_category_id = $contractClass[0]->class_category_id;

            $classLectorsList = ClassLector::where('contract_class_id',$id)->get();
            foreach($classLectorsList as $user){

                $class_category_id = $user->class_category_id;
                $main_yn = $user->main_yn;   // 0:sub, 1:main
                if($main_yn){
                    ClassCategoryUser::where('class_category_id', $class_category_id)
                                     ->where('user_id', $user->user_id)
                                     ->decrement('main_count', 1);

                }else{
                    ClassCategoryUser::where('class_category_id', $class_category_id)
                                     ->where('user_id', $user->user_id)
                                     ->decrement('sub_count', 1);
                }

                ClassLector::where('contract_class_id', $id)
                            ->where('user_id', $user->user_id)
                            ->update([
                                'lector_cost' => '0',
                                'main_count'  => '0',
                                'sub_count'   => '0',
                                'lector_main_count' => '0',
                                'lector_main_cost' => '0',
                                'lector_extra_count' => '0',
                                'lector_extra_cost' => '0',
                                ]);

            }

            //교육완료 취소시 활동일지 삭제
            // $report = ClassReport::where('contract_class_id', $id)->first();
            // if(!empty($report) && !empty($report->id)){

            //     $fileInfo = UserFile::where('id', $report->file_id)->first();
            //     if(!empty($fileInfo) && !empty($fileInfo->file_name)){
            //         Storage::delete($fileInfo->file_path.'/'.$fileInfo->file_name);
            //         UserFile::where('id',$report->file_id)->delete();
            //     }

            //     ClassReport::where('contract_class_id', $id)->delete();
            // }


            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg'=>'처리중 오류가 발생 하였습니다. 잠시후 다시 시도해 주세요.']);
        }

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }

    public function updateClassStatus(Request $request){

        try {
            DB::beginTransaction();

            $id = $request->input('id');
            $class_status = $request->input('class_status');

            ContractClass::where('id',$id)
                            ->update([
                                'class_status'=>$class_status
                            ]);

            $contractClass = ContractClass::where('id',$id)->get();
            //$class_category_id = $contractClass[0]->class_category_id;
            $class_type = $contractClass[0]->class_type; //0 :오프, 1:온라인, 2:동영
            $online_type = $contractClass[0]->online_type; //0: 최초, 1:재방
            $class_order = $contractClass[0]->class_order; //수업차수

            $finance = $contractClass[0]->finance;              //주강사 재원 4,5인 경우 금액 0, 카운트만 +1
            $sub_finance = $contractClass[0]->sub_finance;      //보조강사 재원 4,5인 경우 금액 0, 카운트만 +1

            $classLectorsList = ClassLector::where('contract_class_id',$id)->get();
            foreach($classLectorsList as $user){

                $class_category_id = $user->class_category_id;

                $classCateUser = ClassCategoryUser::where('class_category_id', $class_category_id)
                                                  ->where('user_id', $user->user_id)->get();


                $main_count = $classCateUser[0]->main_count;
                $sub_count = $classCateUser[0]->sub_count;

                $main_yn = $user->main_yn;   // 0:sub, 1:main

                $lector_cost =0;
                $lector_main_count=1;
                $lector_main_cost =0;
                $lector_extra_count=0;
                $lector_extra_cost=0;

                if($main_yn){                                       //주강사

                    if($class_type < 2){                            //오프라인, 온라인실시간

                        if($main_count >= 10){                      //주강사 10회 초과시
                            $lector_main_cost = 50000;
                            $lector_cost = $lector_main_cost;
                            if($class_order > 1){                   //추가시간 기본1보다 클경우에만 적용
                                $lector_extra_count = $class_order-1;
                                $lector_extra_cost=(25000*$lector_extra_count);
                                $lector_cost += $lector_extra_cost;
                            }

                        }else{
                            $lector_main_cost = 30000;
                            $lector_cost = $lector_main_cost;
                            if($class_order > 1){                   //추가시간 기본1보다 클경우에만 적용
                                $lector_extra_count = $class_order-1;
                                $lector_extra_cost=(10000*$lector_extra_count);
                                $lector_cost += $lector_extra_cost;
                            }
                        }

                    } else {                                        //온라인 동영상

                        if(!$online_type){                          //최초방송:0, 재방:1

                            if($main_count >= 10){                      //주강사 10회 초과시
                                $lector_main_cost = 50000;
                                $lector_cost = $lector_main_cost;
                                if($class_order > 1){                   //추가시간 기본1보다 클경우에만 적용
                                    $lector_extra_count = $class_order-1;
                                    $lector_extra_cost=(25000*$lector_extra_count);
                                    $lector_cost += $lector_extra_cost;
                                }

                            }else{                                      //10회 이하
                                $lector_main_cost = 30000;
                                $lector_cost = $lector_main_cost;
                                if($class_order > 1){                   //추가시간 기본1보다 클경우에만 적용
                                    $lector_extra_count = $class_order-1;
                                    $lector_extra_cost=(10000*$lector_extra_count);
                                    $lector_cost += $lector_extra_cost;
                                }
                            }

                        } else {                                        //재방

                            if($main_count >= 10){                      //주강사 10회 초과시
                                $lector_main_cost = 30000;
                                $lector_cost = $lector_main_cost;
                                if($class_order > 1){                   //추가시간 기본1보다 클경우에만 적용
                                    $lector_extra_count = $class_order-1;
                                    $lector_extra_cost=(30000*$lector_extra_count);
                                    $lector_cost += $lector_extra_cost;
                                }
                            }else{                                      //10회 이하
                                $lector_main_cost = 30000;
                                $lector_cost = $lector_main_cost;
                                if($class_order > 1){                   //추가시간 기본1보다 클경우에만 적용
                                    $lector_extra_count = $class_order-1;
                                    $lector_extra_cost=(10000*$lector_extra_count);
                                    $lector_cost += $lector_extra_cost;
                                }
                            }

                        }

                    }

                    //재원에 따른 0처리
                    if($finance == 4 || $finance == 5 ) {
                        $lector_cost  = 0;
                        $lector_main_cost =0;
                        $lector_extra_cost =0;
                    }

                } else {                                                //보조강사

                    if($class_type < 2){                                //오프라인, 온라인실시간
                        $lector_main_cost = 20000;
                        $lector_cost = $lector_main_cost;
                        if($class_order > 1){                           //추가시간 기본1보다 클경우에만 적용
                            $lector_extra_count = $class_order-1;
                            $lector_extra_cost=(10000*$lector_extra_count);
                            $lector_cost += $lector_extra_cost;
                        }
                    } else {                                            //온라인동영상
                        $lector_main_cost = 20000;
                        $lector_cost = $lector_main_cost;
                    }

                    //재원에 따른 0처리
                    if($sub_finance == 4 || $sub_finance == 5){
                        $lector_cost  = 0;
                        $lector_main_cost =0;
                        $lector_extra_cost =0;
                    }

                }


                if($main_yn){
                    ClassCategoryUser::where('class_category_id', $class_category_id)
                                    ->where('user_id', $user->user_id)
                                    ->increment('main_count', 1);
                    $main_count++;
                }else{
                    ClassCategoryUser::where('class_category_id', $class_category_id)
                                    ->where('user_id', $user->user_id)
                                    ->increment('sub_count', 1);
                    $sub_count++;
                }


                ClassLector::where('contract_class_id', $id)
                            ->where('user_id', $user->user_id)
                            ->update([
                                'lector_cost' => $lector_cost,
                                'main_count'  => $main_count,
                                'sub_count'   => $sub_count,
                                'lector_main_count' => $lector_main_count,
                                'lector_main_cost' => $lector_main_cost,
                                'lector_extra_count' => $lector_extra_count,
                                'lector_extra_cost' => $lector_extra_cost,
                                ]);

            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg'=>'처리중 오류가 발생 하였습니다. 잠시후 다시 시도해 주세요.']);
        }

        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);

    }



    public function updatePayment(Request $request){

        $ids = $request->input('contract_class_id');
        $inputIds = explode(',', $ids);
        ContractClass::whereIn('id', $inputIds)
                        ->update([
                            'class_status'=> 3
                        ]);


        return response()->json(['msg'=>'정상적으로 처리 하였습니다.']);
    }

}
