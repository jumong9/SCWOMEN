@extends('layouts.main_layout')

@section('content')
    <div id="modalFrame"></div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.payreport.list') }}" method="post" >
        <input name="checkedItemId" type="hidden" value=""/>
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <div class="float-left">
                <div class="form-inline">
                    <select name="perPage" id="perPage" class="form-control float-left mr-2">
                        <option value="5" {{$classList->perPage() == 5 ? "selected" : "" }} >5</option>
                        <option value="10" {{$classList->perPage() == 10 ? "selected" : "" }}>10</option>
                        <option value="30" {{$classList->perPage() == 30 ? "selected" : "" }}>30</option>
                        <option value="50" {{$classList->perPage() == 50 ? "selected" : "" }}>50</option>
                    </select>
                    <span >전체 {{ $classList->total() }} 건</span>
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
                        <input style="width: 110px;" type="text" class="form-control datepicker " id="searcFromDate" name="searcFromDate" value="{{ $searcFromDate }}" placeholder="시작일">
                        <input style="width: 110px;" type="text" class="form-control datepicker" id="searcToDate" name="searcToDate" value="{{ $searcToDate }}" placeholder="종료일">
                        <input type="text" class="form-control" id="searchWord" name="searchWord" value="{{ $searchWord }}" placeholder="강사명">
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
                            <th>강사명</th>
                            <th>활동일자</th>
                            <th>시간</th>
                            <th>자격</th>
                            <th>지급기준</th>
                            <th>횟수</th>
                            <th>차수</th>
                            <th>강사비</th>
                            {{-- <th>재료비</th> --}}
                            <th>총액</th>
                            <th>소득세</th>
                            <th>주민세</th>
                            <th>실지급액</th>
                            <th>수요처</th>
                            <th>프로그램</th>
                            <th>활동일지</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classList as $key => $list)
                        <tr>

                            <td>{{ $list->name}}</td>
                            <td>{{ $list->class_day,'Y-m-d'}}</td>
                            <td>{{ $list->time_from}} - {{ $list->time_to}}</td>
                            <td>{{ $list->main_yn == 0 ? '보조강사' : '주강사' }}</td>
                            <td>{{ $list->main_yn == 0 ? $list->my_sub_count : $list->my_main_count }}회</td>
                            <td>{{ $list->class_count}}</td>
                            <td>{{ $list->class_order}}</td>
                            <td>{{ number_format($list->lector_cost) }}</td>
                            {{-- <td>{{ $list->main_yn == 1 ? number_format($list->material_cost) : 0 }}</td> --}}
                            <td>{{ number_format( $list->tot ) }} </td>
                            <td>{{ number_format( $list->i_tax ) }} </td>
                            <td>{{ number_format( $list->r_tax ) }} </td>
                            <td>{{ number_format( $list->pay ) }} </td>
                            <td>{{ $list->client_name}} </td>
                            <td>{{ $list->class_name }} </td>
                            <td>{{ $list->class_status == 2 ? '작성완료':'' }} </td>

                        @endforeach
                    </tbody>
                </table>
                {{ $classList->withQueryString()->links() }}
            </div>
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button" name="exportExcelButton" id="exportExcelButton">엑셀다운로드</button>
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

            $("#exportExcelButton").click(function(e){
                $("#searchForm").attr("action", "{{ route('mgmt.payreport.exportExcel') }}");
                $("#searchForm").submit();
                $("#searchForm").attr("action", "{{route('mgmt.payreport.list') }}");
            });

        });
    </script>
@endsection
