<?php

namespace App\Http\Controllers\common\board;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\UserFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

use function PHPUnit\Framework\isEmpty;

class BoardController extends Controller
{
    public function __construct(){

        $this->filePath = "uploads/".date("Y")."/board_notice";
        $this->pageTitle = "공지사항";
    }

    public function resetCommonData($board_id){

        if($board_id == 'documents') {
            $this->pageTitle = "서식자료함";
            $this->filePath = "uploads/".date("Y")."/board_documents";
        }
    }


    public function list(Request $request){

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $board_id = empty($request->input('board_id') ) ?'notice' : $request->input('board_id') ;
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        DB::enableQueryLog();

        $this->resetCommonData($board_id);

        $boardList = Board::where('board_id', $board_id)
                          ->where('board_title','LIKE',"{$searchWord}%")
                          ->orderBy('important_yn', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->paginate($perPage);

        $boardList->appends (array ('board_id'=>$board_id, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord));


        //dd(DB::getQueryLog());
        return view('common.board.list', ['board_id'=>$board_id, 'contentList'=>$boardList, 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page] );

    }


    public function create(Request $request){

        if(90 > Auth::user()->grade){
            return view('errors.404');
        }

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $board_id = empty($request->input('board_id') ) ?'notice' : $request->input('board_id') ;
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');

        $this->resetCommonData($board_id);

        return view('common.board.create', ['board_id'=>$board_id, 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page] );


    }


    public function createDo(Request $request){

        if(90 > Auth::user()->grade){
            return view('errors.404');
        }

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $board_id = empty($request->input('board_id') ) ?'notice' : $request->input('board_id') ;
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');


        $this->resetCommonData($board_id);

        try {
            DB::beginTransaction();

            $user_id = Auth::id();
            $user_name = Auth::user()->name;
            $file = $request->file('upload_file');
            $file2 = $request->file('upload_file2');
            $file_id =null;
            $file_id2 =null;

            if(!empty($file)){
                $file_real_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_mime = $file->getMimeType();
                $random_file_name = UserFile::getFileId();

                //Move Uploaded File
                $destinationPath = $this->filePath;
                $file->storeAs($destinationPath, $random_file_name);

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
            }

            if(!empty($file2)){
                $file_real_name = $file2->getClientOriginalName();
                $file_extension = $file2->getClientOriginalExtension();
                $file_size = $file2->getSize();
                $file_mime = $file2->getMimeType();
                $random_file_name = UserFile::getFileId();

                //Move Uploaded File
                $destinationPath = $this->filePath;
                $file2->storeAs($destinationPath, $random_file_name);

                $file_arr = [
                    "file_name"             =>  $random_file_name,
                    "file_path"             =>  $destinationPath,
                    "file_real_name"        =>  $file_real_name,
                    "file_extension"        =>  $file_extension,
                    "file_size"             =>  $file_size,
                    "file_mime"             =>  $file_mime,
                    "user_id"               =>  $user_id,
                ];

                $file_id2 = UserFile::create($file_arr)->id;
            }





            $board_id = $request->input('board_id');
            $board_title = $request->input('board_title');
            $board_contents = $request->input('board_contents');
            $board_important = isEmpty($request->input('important_yn')) ? '0' : '1';

            $created_id = $user_id;
            $created_name = $user_name;

            $board_item = [
                "board_id"              =>  $board_id,
                "board_title"           =>  $board_title,
                "board_contents"        =>  $board_contents,
                "important_yn"          =>  $board_important,
                "file_id"               =>  $file_id,
                "file_id2"              =>  $file_id2,
                "created_id"            =>  $created_id,
                "created_name"          =>  $created_name,
                "updated_id"            =>  $created_id,
                "updated_name"          =>  $created_name,
            ];

            $item_id = Board::create($board_item)->id;


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

        return redirect()->route('common.board.read', ['id'=>$item_id, 'board_id'=>$board_id, 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page] );

    }

    public function read(Request $request){

        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $board_id = empty($request->input('board_id') ) ?'notice' : $request->input('board_id') ;
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        $id = $request->input('id');

        $this->resetCommonData($board_id);

        $board = Board::where('id', $id)
                        ->where('board_id', $board_id)
                        ->first();


        $file_id = $board->file_id;
        $file_id2 = $board->file_id2;

        $fileInfo=null;
        if(!empty($file_id)){
            $fileInfo = UserFile::where('id', $file_id)
                                ->first();
        }

        $fileInfo2=null;
        if(!empty($file_id2)){
            $fileInfo2 = UserFile::where('id', $file_id2)
                                ->first();
        }
   //     dd(DB::getQueryLog());

        return view('common.board.read', ['boardInfo'=>$board, 'fileInfo'=>$fileInfo, 'fileInfo2'=>$fileInfo2, 'board_id'=>$board_id, 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page] );

    }


    public function update(Request $request){

        if(90 > Auth::user()->grade){
            return view('errors.404');
        }

        DB::enableQueryLog();
        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $board_id = empty($request->input('board_id') ) ?'notice' : $request->input('board_id') ;
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        $id = $request->input('id');

        $this->resetCommonData($board_id);

        $board = Board::where('id', $id)
                        ->where('board_id', $board_id)
                        ->first();


        $file_id = $board->file_id;
        $file_id2 = $board->file_id2;

        $fileInfo=null;
        if(!empty($file_id)){
            $fileInfo = UserFile::where('id', $file_id)
                                ->first();
        }

        $fileInfo2=null;
        if(!empty($file_id2)){
            $fileInfo2 = UserFile::where('id', $file_id2)
                                ->first();
        }
   //     dd(DB::getQueryLog());

        return view('common.board.update', ['boardInfo'=>$board, 'fileInfo'=>$fileInfo, 'fileInfo2'=>$fileInfo2, 'board_id'=>$board_id, 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page] );

    }

    public function updateDo(Request $request){

        if(90 > Auth::user()->grade){
            return view('errors.404');
        }


        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $board_id = empty($request->input('board_id') ) ?'notice' : $request->input('board_id') ;
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        $id = $request->input('id');
        $important_yn = empty($request->input('important_yn')) ? '0' : '1';


        $user_id = Auth::id();
        $user_name =  Auth::user()->name;

        $delete_old_file = $request->input('delete_old_file');
        $file_id = $request->input('old_file_id');
        $old_file_id = $request->input('old_file_id');
        $old_file_name = $request->input('old_file_name');
        $file = $request->file('upload_file');

        $delete_old_file2 = $request->input('delete_old_file2');
        $file_id2 = $request->input('old_file_id2');
        $old_file_id2 = $request->input('old_file_id2');
        $old_file_name2 = $request->input('old_file_name2');
        $file2 = $request->file('upload_file2');

        try {
            DB::beginTransaction();

            if(!empty($file)){                                      //새로운 파일 업로드
                $file_real_name = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_mime = $file->getMimeType();
                $random_file_name = UserFile::getFileId();


                //Move Uploaded File
                $destinationPath = $this->filePath;
                $file->storeAs($destinationPath, $random_file_name);

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

            }else if($delete_old_file == 'Y'){
                Storage::delete($this->filePath.'/'.$old_file_name);
                UserFile::where('id',$old_file_id)->delete();
            }

            if(!empty($file2)){                                      //새로운 파일 업로드
                $file_real_name = $file2->getClientOriginalName();
                $file_extension = $file2->getClientOriginalExtension();
                $file_size = $file2->getSize();
                $file_mime = $file2->getMimeType();
                $random_file_name = UserFile::getFileId();


                //Move Uploaded File
                $destinationPath = $this->filePath;
                $file2->storeAs($destinationPath, $random_file_name);

                $file_arr = [
                    "file_name"             =>  $random_file_name,
                    "file_path"             =>  $destinationPath,
                    "file_real_name"        =>  $file_real_name,
                    "file_extension"        =>  $file_extension,
                    "file_size"             =>  $file_size,
                    "file_mime"             =>  $file_mime,
                    "user_id"               =>  $user_id,
                ];
                $file_id2 = UserFile::create($file_arr)->id;

                //기존파일 삭제
                //$file->delete($destinationPath, $old_file_name);
                Storage::delete($destinationPath.'/'.$old_file_name2);
                UserFile::where('id',$old_file_id2)->delete();

            }else if($delete_old_file2 == 'Y'){
                Storage::delete($this->filePath.'/'.$old_file_name2);
                UserFile::where('id',$old_file_id2)->delete();
            }


            Board::where('id', $id)
                    ->where('board_id', $board_id)
                    ->update([
                        'board_title' => $request->input('board_title'),
                        'board_contents' => $request->input('board_contents'),
                        'important_yn' => $important_yn,
                        'file_id'=> $file_id,
                        'file_id2'=> $file_id2,
                        'updated_id'=> $user_id,
                        'updated_name'=> $user_name,
                    ]);


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }

        return redirect()->route('common.board.read', ['id'=>$id, 'board_id'=>$board_id, 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page] );


    }


    public function delete(Request $request){

        if(90 > Auth::user()->grade){
            return view('errors.404');
        }

        $searchType = $request->input('searchType');
        $searchWord = $request->input('searchWord');
        $board_id = empty($request->input('board_id') ) ?'notice' : $request->input('board_id') ;
        $perPage = empty($request->input('perPage') ) ? 10 : $request->input('perPage');
        $page = $request->input('page');
        $id = $request->input('id');

        try {
            DB::beginTransaction();

            $boardInfo = Board::where('id', $id)
                                ->where('board_id', $board_id)
                                ->first();

            if(!empty($boardInfo->file_id)){
                $fileInfo = UserFile::where('id', $boardInfo->file_id)->first();
                Storage::delete($fileInfo->file_path.'/'.$fileInfo->file_name);
                UserFile::where('id',$boardInfo->file_id)->delete();
            }

            if(!empty($boardInfo->file_id2)){
                $fileInfo2 = UserFile::where('id', $boardInfo->file_id2)->first();
                Storage::delete($fileInfo2->file_path.'/'.$fileInfo2->file_name);
                UserFile::where('id',$boardInfo->file_id2)->delete();
            }

            Board::where('id', $id)->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return view('errors.500');
        }


        return redirect()->route('common.board.list', ['board_id'=>$board_id, 'pageTitle'=>$this->pageTitle, 'perPage' => $perPage, 'searchType' => $searchType, 'searchWord' => $searchWord, 'page' => $page] );


    }

}
