@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.contract.list') }}" method="post" >
        <input name="checkedItemId" type="hidden" value=""/>
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <div class="float-left">
                <div class="form-inline">
                    <select name="perPage" id="perPage" class="form-control float-left mr-2">
                        <option value="5" {{$contractList->perPage() == 5 ? "selected" : "" }} >5</option>
                        <option value="10" {{$contractList->perPage() == 10 ? "selected" : "" }}>10</option>
                        <option value="30" {{$contractList->perPage() == 30 ? "selected" : "" }}>30</option>
                        <option value="50" {{$contractList->perPage() == 50 ? "selected" : "" }}>50</option>
                    </select>
                    <span >전체 {{ $contractList->total() }} 건</span>
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
                            <th>구분</th>
                            <th>수요처</th>
                            <th>담당자</th>
                            <th>연락처</th>
                            <th>총강사비</th>
                            <th>총재료비</th>
                            <th>입금상태</th>
                            <th>진행상태</th>
                            <th>등록일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contractList as $key => $list)
                        <tr>
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
                            <td><a href="{{ route ('mgmt.contract.read', ['id'=>$list->id, 'perPage'=>$contractList->perPage(), 'page'=>$contractList->currentPage(), 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $list->client_name }}</a></td>
                            <td>{{ $list->name}}</td>
                            <td>{{ $list->phone}}</td>
                            <td>{{ $list->class_total_cost}}</td>
                            <td>{{ $list->material_total_cost}}</td>
                            <td>{{ $list->paid_yn == 0 ? '미입금' : '입금완료' }}</td>
                            <td>{{ $list->code_value}}</td>
                            <td>{{ date_format($list->created_at,'Y-m-d')}}</td>
                        @endforeach
                    </tbody>
                </table>
                {{ $contractList->withQueryString()->links() }}
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
