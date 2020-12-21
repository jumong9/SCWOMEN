@extends('layouts.main_layout')

@section('content')

<div id="modalFrame"></div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm" action="{{route('common.board.createDo') }}" onsubmit="return searchFormSubmit();" method="post" enctype="multipart/form-data" >
        @csrf

        <input name="board_id" type="hidden" value="{{ $board_id }}"/>
        <input type="hidden" name="searchType" value="{{ $searchType }}">
        <input type="hidden" name="searchWord" value="{{ $searchWord }}">
        <input type="hidden" name="perPage" value="{{ $perPage }}">
        <input type="hidden" name="page" value="{{ $page }}">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table">
                    <table class="table" id="" cellspacing="0">
                        <colgroup>
                            <col width="200px">
                            <col>
                        </colgroup>
                        <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            <tr>
                                <th>제목</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input id="board_title" type="text" class="form-control @error('board_title') is-invalid @enderror" name="board_title"  required >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>내용</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="board_contents" name="board_contents" rows="9"></textarea>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>첨부파일</th>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="file" class="form-control-file" id="upload_file" name="upload_file">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row-fluid" style="text-align: right;">
                    <button class="btn btn-primary" type="submit"  id="createButton">저장</button>
                    <button class="btn btn-primary" type="button"  id="calcelButton">취소</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')


    <!-- Custom scripts for all pages-->
    <script>

        $(document).ready(function() {

            var params = "?board_id={{$board_id}}&perPage={{$perPage}}&page={{$page}}&searchType={{$searchType}}&searchWord={{$searchWord}}";

            $("#createButton").click(function(){
                return ture;
            });

            $("#calcelButton").click(function(){
                location.href='{{ route('common.board.list')}}' + params ;
            });

        });

    </script>


@endsection
