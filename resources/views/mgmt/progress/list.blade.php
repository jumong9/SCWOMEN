@extends('layouts.main_layout')

@section('content')
    <div id="modalFrame"></div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.progress.list') }}" method="post" >
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

                        <input style="width: 110px;" type="text" class="form-control datepicker " id="searcFromDate" name="searcFromDate" value="{{ $searcFromDate }}" placeholder="시작일">
                        <input style="width: 110px;" type="text" class="form-control datepicker" id="searcToDate" name="searcToDate" value="{{ $searcToDate }}" placeholder="종료일">
                        <select class="form-control" name="searchType" id="searchType">
                            <option value="">선택하세요</option>
                            <option value="client_name" {{ $searchType == 'client_name' ? "selected" : "" }} >수요처명</option>
                            <option value="contract_id" {{ $searchType == 'contract_id' ? "selected" : "" }} >계약번호</option>
                        </select>

                        <input type="text" class="form-control" id="searchWord" name="searchWord" value="{{ $searchWord }}" placeholder="계약번호">
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
                            <th>활동일자</th>
                            <th>시간</th>
                            <th>수요처</th>
                            <th>프로그램</th>
                            <th>교육대상</th>
                            <th>인원</th>
                            <th>횟수</th>
                            <th>차수</th>
                            <th>주강사</th>
                            <th>보조강사</th>
                            <th>배정</th>
                            <th>수업</th>
                            <th>활동일지</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classList as $key => $list)
                        <tr>
                            <td><a href="{{ route ('mgmt.contract.read', ['id'=>$list->contract_id, 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $list->contract_id}}</a></td>
                            <td>{{ $list->class_day,'Y-m-d'}}</td>
                            <td>{{ $list->time_from}} - {{ $list->time_to}}</td>
                            <td>{{ $list->client_name}}</td>
                            <td><a href="{{ route ('mgmt.lecture.read', ['id'=>$list->id, 'perPage'=>$classList->perPage(), 'page'=>$classList->currentPage(), 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $list->class_name }} </a></td>
                            <td>{{ $list->class_target}}</td>
                            <td>{{ $list->class_number}}</td>
                            <td>{{ $list->class_count}}</td>
                            <td>{{ $list->class_order}}</td>
                            <td>{{ $list->main_count}}</td>
                            <td>{{ $list->sub_count}}</td>
                            <td>{{ $list->lector_apply_yn == 0 ? '배정중' : '배정완료' }}</td>
                            <td>{{ $list->class_status == 0 ? '수업예정' : '수업완료' }}</td>
                            <td>{{ $list->class_status == 2 ? '작성완료' : '미작성' }}</td>
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

            $("#exportExcelButton").click(function(e){
                $("#searchForm").attr("action", "{{ route('mgmt.progress.exportExcel') }}");
                $("#searchForm").submit();
                $("#searchForm").attr("action", "{{route('mgmt.progress.list') }}");
            });

            $("#approvalButton").click(function(e){

                if($("input:checkbox[name=id]:checked").length == 0){
                    alert("강사 배정 할 대상을 선택해 주세요.")
                    return false;
                }

                var checkIds = [];
                var checkCateIds;
                var loop =0;
                var pass =true;
                $.each($("input:checkbox[name=id]:checked"), function(){
                    if(loop==0) {
                        checkCateIds = $(this).data('class_id');
                        loop++;
                    }else if(checkCateIds != $(this).data('class_id')){
                        alert("동일한 프로그램만 다중 선택이 가능합니다.");
                        pass=false;
                        return false;
                    }

                    checkIds.push($(this).val());
                });

                if(pass){
                    $.ajax({
                        type : "post",
                        url : "{{ route('grade.lecture.popupUserMulti') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'contract_class_id' : checkIds.join(","),
                            'class_category_id' : checkCateIds,
                        },
                        success : function(data){
                            $("#modalFrame").html(data);
                            $("#showModal").modal("show");
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    });
                }

            });




        });
    </script>
@endsection
