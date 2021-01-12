@extends('layouts.main_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm"  action="{{route('common.board.list') }}" method="post" >
        <input name="board_id" type="hidden" value="{{ $board_id }}"/>
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <div class="float-left">
                <div class="form-inline">
                    <select name="perPage" id="perPage" class="form-control float-left mr-2">
                        <option value="5" {{$contentList->perPage() == 5 ? "selected" : "" }} >5</option>
                        <option value="10" {{$contentList->perPage() == 10 ? "selected" : "" }}>10</option>
                        <option value="30" {{$contentList->perPage() == 30 ? "selected" : "" }}>30</option>
                        <option value="50" {{$contentList->perPage() == 50 ? "selected" : "" }}>50</option>
                    </select>
                    <span >전체 {{ $contentList->total() }} 건</span>
                </div>
            </div>
            <div class="float-right">
                <div class="form-inline">
                    <div class="form-group">
                        {{--
                        <select class="form-control" name="searchType" id="searchType">
                            <option value="">선택하세요</option>
                            <option value="name" {{ $searchType == 'name' ? "selected" : "" }} >이름</option>
                            <option value="group" {{ $searchType == 'group' ? "selected" : "" }} >기수</option>
                        </select>
                        --}}
                        <input type="text" class="form-control" id="searchWord" name="searchWord" value="{{ $searchWord }}" placeholder="제목">
                        <button type="button" name="searchButton" id="searchButton" class="btn btn-primary ml-2">검색</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>제목</th>
                            <th style="width: 10%;">등록일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php ($no = $contentList->total() - $contentList->perPage() * ($contentList->currentPage()-1))
                        @foreach($contentList as $key => $list)
                        <tr>
                            <td>{{$no--}}</td>
                            <td><a href="{{ route ('common.board.read', ['id'=>$list->id, 'board_id'=>$list->board_id, 'perPage'=>$contentList->perPage(), 'page'=>$contentList->currentPage(), 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $list->board_title}}</a></td>
                            <td>{{ $list->created_at->format('Y-m-d')}}</td>
                        @endforeach
                    </tbody>
                </table>
                {{ $contentList->withQueryString()->links() }}
            </div>
            @if (Auth::user()->grade >=90 )
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button" name="createButton" id="createButton">등록</button>
            </div>
            @endif
        </div>
    </div>
    </form>
@endsection

@section('scripts')
    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {

            var params = "?board_id={{$board_id}}&perPage={{$perPage}}&page={{$page}}&searchType={{$searchType}}&searchWord={{$searchWord}}";


            $("#perPage").change(function(){
                $("#searchButton").trigger("click");
            });

            $("#searchButton").click(function(){
                $("#searchForm").submit();
            });

            $("#createButton").click(function(){
                location.href='{{ route('common.board.create') }}' + params ;
            });

        });
    </script>
@endsection
