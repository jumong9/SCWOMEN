@extends('layouts.main_layout')

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
                        <select class="form-control" name="searchType" id="searchType">
                            <option value="">구분</option>
                            @foreach($clientGubunList as $key => $code)
                                <option value="{{$code->code_id}}" {{ $searchType == $code->code_id ? "selected" : "" }}>{{$code->code_value}}
                            @endforeach
                        </select>
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
                            <th>계약번호</th>
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
                            <td>{{ $list->id}}</td>
                            <td>{{ $list->client_gubun}}
                            </td>
                            <td><a href="{{ route ('mgmt.contract.read', ['id'=>$list->id, 'perPage'=>$contractList->perPage(), 'page'=>$contractList->currentPage(), 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $list->client_name }}</a></td>
                            <td>{{ $list->name}}</td>
                            <td>{{ $list->phone}}</td>
                            <td>{{ number_format($list->class_total_cost) }}</td>
                            <td>{{ number_format($list->material_total_cost) }}</td>
                            <td>{{ $list->paid_yn == 0 ? '미입금' : '입금완료' }}</td>
                            <td>{{ $list->code_value}}</td>
                            <td>{{ date_format($list->created_at,'Y-m-d')}}</td>
                        @endforeach
                    </tbody>
                </table>
                {{ $contractList->withQueryString()->links() }}
            </div>
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button" name="exportExcelButton" id="exportExcelButton">엑셀다운로드</button>
            </div>
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


            $("#exportExcelButton").click(function(e){
                $("#searchForm").attr("action", "{{ route('mgmt.contract.exportExcel') }}");
                $("#searchForm").submit();
                $("#searchForm").attr("action", "{{route('mgmt.contract.list') }}");
            });



        });
    </script>
@endsection
