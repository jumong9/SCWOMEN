@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">수요처관리</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.client.list') }}" method="post" >
        <input name="checkedItemId" type="hidden" value=""/>
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <div class="float-left">
                <div class="form-inline">
                    <select name="perPage" id="perPage" class="form-control float-left mr-2">
                        <option value="5" {{$contentslist->perPage() == 5 ? "selected" : "" }} >5</option>
                        <option value="10" {{$contentslist->perPage() == 10 ? "selected" : "" }}>10</option>
                        <option value="30" {{$contentslist->perPage() == 30 ? "selected" : "" }}>30</option>
                        <option value="50" {{$contentslist->perPage() == 50 ? "selected" : "" }}>50</option>
                    </select>
                    <span >전체 {{ $contentslist->total() }} 건</span>
                </div>
            </div>
            <div class="float-right">
                <div class="form-inline">
                    <div class="form-group mb-2">
                        {{--
                        <select class="form-control" name="searchType" id="searchType">
                            <option value="">선택하세요</option>
                            <option value="name" {{ $searchType == 'name' ? "selected" : "" }} >이름</option>
                            <option value="group" {{ $searchType == 'group' ? "selected" : "" }} >기수</option>
                        </select>
                        --}}
                        <input type="text" class="form-control" id="searchWord" name="searchWord" value="{{ $searchWord }}" placeholder="수요처명">
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
                            <th>
                                @if($searchStatus == 0)
                                    <input type="checkbox" id="selectAllCheck">
                                @endif
                            </th>
                            <th>구분</th>
                            <th>수요처명</th>
                            <th>대표전화</th>
                            <th>대표팩스</th>
                            <th>행정실전화</th>
                            <th>행정실팩스</th>
                            <th>등록일</th>
                            <th>계약</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contentslist as $key => $list)
                        <tr>
                            <td>
                                @if($searchStatus == 0)
                                    <input type="checkbox" name="id" value="{{ $list->id }}">
                                @endif
                            </td>
                            <td>
                                @switch($list->gubun)
                                    @case(1)
                                        초등학교
                                        @break
                                    @case(2)
                                        중학교
                                        @break
                                    @case(3)
                                        고등학교
                                        @break
                                    @case(4)
                                        돌봄
                                        @break
                                    @case(5)
                                        유아
                                        @break
                                    @case(6)
                                        아파트
                                        @break
                                    @default
                                        기타
                                @endswitch
                            </td>
                            <td><a href="{{ route ('mgmt.client.read', ['id'=>$list->id, 'perPage'=>$contentslist->perPage(), 'page'=>$contentslist->currentPage(), 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $list->name }}</a></td>
                            <td>{{ $list->client_tel}}</td>
                            <td>{{ $list->client_fax}}</td>
                            <td>{{ $list->office_tel}}</td>
                            <td>{{ $list->office_fax }}</td>
                            <td>{{ $list->created_at}}</td>
                            <td><a href="{{ route('mgmt.client.list') }}">등록</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $contentslist->withQueryString()->links() }}
            </div>
            <div class="row-fluid" style="text-align: right;">
                @if($searchStatus == 0)
                    <button class="btn btn-primary" type="button" name="createButton" id="createButton">등록</button>
                @endif
            </div>
        </div>
    </div>
    </form>
@endsection

@section('scripts')
    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {


            $("#perPage").change(function(){
                $("#searchButton").trigger("click");
            });

            $("#searchButton").click(function(){
                $("#searchForm").submit();
            });

            $("#selectAllCheck").click(function(){
                if($("#selectAllCheck").prop("checked")) {
                    $("input[type=checkbox]").prop("checked",true);
                } else {
                    $("input[type=checkbox]").prop("checked",false);
                }

            });

            $("#createButton").click(function(){
                location.href='{{ route('mgmt.client.create')}}';
            });




        });
    </script>
@endsection
