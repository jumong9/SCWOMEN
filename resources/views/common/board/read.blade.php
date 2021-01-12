@extends('layouts.main_layout')

@section('content')

<div id="modalFrame"></div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table">
                    <table class="table" id="" >
                        <colgroup>
                            <col width="200px">
                            <col >
                        </colgroup>
                        <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            <tr>
                                <th>제목</th>
                                <td>
                                    {{ $boardInfo->board_title }}
                                </td>
                            </tr>
                            <tr>
                                <th>내용</th>
                                <td colspan="3">
                                    {!! nl2br($boardInfo->board_contents) !!}
                                </td>
                            </tr>
                            @if (!empty($fileInfo))
                            <tr>
                                <th>첨부파일</th>
                                <td colspan="3">

                                        <a href="{{ route('common.file.fileDown')}}?file_id={{$fileInfo->file_name}}">{{ $fileInfo->file_real_name }}</a>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($fileInfo2))
                            <tr>
                                <th>첨부파일</th>
                                <td colspan="3">
                                        <a href="{{ route('common.file.fileDown')}}?file_id={{$fileInfo2->file_name}}">{{ $fileInfo2->file_real_name }}</a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>등록일</th>
                                <td>
                                    {{ $boardInfo->created_at->format('Y-m-d') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row-fluid" style="text-align: right;">
                    @if (Auth::user()->grade >=90 )
                        <button class="btn btn-primary" type="button"  id="updateButton">수정</button>
                        <button class="btn btn-primary" type="button"  id="deleteButton">삭제</button>
                    @endif
                    <button class="btn btn-primary" type="button"  id="listButton">목록</button>
                </div>

            </div>
        </div>

@endsection

@section('scripts')


    <!-- Custom scripts for all pages-->
    <script>

        $(document).ready(function() {

            var params = "?board_id={{$board_id}}&perPage={{$perPage}}&page={{$page}}&searchType={{$searchType}}&searchWord={{$searchWord}}";


            $("#listButton").click(function(){
                location.href='{{ route('common.board.list')}}' + params;
            });

            @if (Auth::user()->grade >=90 )
                $("#updateButton").click(function(){
                    location.href='{{ route('common.board.update')}}' + params +"&id={{$boardInfo->id}}";
                });

                $("#deleteButton").click(function(){
                    location.href='{{ route('common.board.delete')}}' + params +"&id={{$boardInfo->id}}";
                });
            @endif

        });

    </script>


@endsection
