@extends('layouts.main_layout')

@section('content')
    <div id="modalFrame"></div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table">
                    <table class="table-sm" id="" cellspacing="0">
                        <colgroup>
                            <col width="200px">
                            <col width="40%">
                            <col width="200px">
                            <col width="40%">
                        </colgroup>
                        <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            <tr>
                                <th>수요처명</th>
                                <td>
                                    {{ $client->name }}
                                </td>
                                <th>구분</th>
                                <td>
                                    {{ $client->code_value }}
                                </td>
                            </tr>
                            {{-- <tr>
                                <th >담당자</th>
                                <td>
                                    {{ $contract->name }}
                                </td>
                                <th >이메일</th>
                                <td>
                                    {{ $contract->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>연락처</th>
                                <td>
                                    {{ $contract->phone }}
                                </td>
                                <th>연락처</th>
                                <td>
                                    {{ $contract->phone2 }}
                                </td>
                            </tr>
                            <tr>
                                <th>회당 강사비</th>
                                <td>
                                    {{ number_format($contract->class_cost) }}
                                </td>
                                <th>총 강사비</th>
                                <td>
                                    {{ number_format($contract->class_total_cost) }}
                                </td>

                            </tr>
                            <tr>
                                <th>인당 재료비</th>
                                <td>
                                    {{ number_format($contract->material_cost) }}
                                </td>
                                <th>총 재료비</th>
                                <td>
                                    {{ number_format($contract->material_total_cost) }}
                                </td>
                            </tr>

                             <tr>
                                <th>인당 재료비</th>
                                <td>
                                    {{ number_format($contract->material_cost) }}
                                </td>
                                <th>총 재료비</th>
                                <td>
                                    {{ number_format($contract->material_total_cost) }}
                                </td>
                            </tr>
                            --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <span>신청 강좌</span>
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table">
                    <table class="table-sm table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:100px;">진행상태</th>
                                <th style="width:100px;">활동일자</th>
                                <th style="width:120px;">시간</th>
                                <th style="width:160px;">프로그램</th>
                                <th style="width:160px;">세부프로그램</th>
                                <th style="width:160px;">교육대상</th>
                                <th style="width:80px;">인원</th>
                                <th style="width:80px;">횟수</th>
                                <th style="width:80px;">차수</th>
                                <th style="width:80px;">주강사수</th>
                                <th style="width:80px;">보조강사수</th>
                                <th style="width:80px;">재료비</th>
                                <th style="width:100px;">수업방식</th>
                                <th style="width:100px;">수업구분</th>
                            </tr>
                        </thead>
                        <tbody id="classList" class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            @foreach($contentsList as $key => $list)
                            <tr>
                                <td>
                                    {{ $list->class_status_value }}
                                </td>
                                <td>
                                    {{ $list->class_day }}
                                </td>
                                <td>
                                    {{$list->time_from}} - {{$list->time_to}}
                                </td>
                                <td>
                                    {{$list->class_name}}
                                </td>
                                <td>
                                    {{$list->class_sub_name}}
                                </td>
                                <td>
                                    {{$list->class_target}}
                                </td>
                                <td>
                                    {{number_format($list->class_number)}}
                                </td>
                                <td>
                                    {{number_format($list->class_count)}}
                                </td>
                                <td>
                                    {{number_format($list->class_order)}}
                                </td>
                                <td>
                                    {{number_format($list->main_count)}}
                                </td>
                                <td>
                                    {{number_format($list->sub_count)}}
                                </td>
                                <td>
                                    {{number_format($list->material_cost)}}
                                </td>
                                <td>
                                    @if($list->class_type == 0 ) 오프라인
                                    @elseif($list->class_type == 1) 온라인 실시간
                                    @else 온라인 동영상
                                    @endif
                                </td>
                                <td>
                                    @if($list->class_type == 2 )
                                        {{$list->online_type == 0? '최초방영' : '재방영'}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <span>강사 배정</span>
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table">
                    <table class="table-sm" id="" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>구분</th>
                                <th>기수</th>
                                <th>강사명</th>
                                <th>핸드폰</th>
                            </tr>
                        </thead>
                        <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            @foreach($lectorsList as $key => $list)
                            <tr class="selecteUser">
                                <td>
                                    {{ $list->main_yn == 1 ? '주강사' : '보조강사' }}
                                </td>
                                <td>
                                    {{ $list->user_group }}
                                </td>
                                <td>
                                    {{ $list->name }}
                                </td>
                                <td>
                                    {{ $list->mobile }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row-fluid" style="text-align: right;">
                    @if($mainYn && $timeDiff)
                        @if($contentsList[0]->class_status >= 1 && $reportNeedYn)
                            <button class="btn btn-primary" type="button"  id="reportButton">활동일지작성</button>
                        @endif
                        @if($contract->status == 6 && $contentsList[0]->class_status == 0)
                            <button class="btn btn-primary" type="button"  id="finishButton" data-status='1'>교육완료</button>
                        @endif
                        <!-- @if($contentsList[0]->class_status == 1 || $contentsList[0]->class_status == 2)
                            <button class="btn btn-primary" type="button"  id="resetButton" data-status='0'>교육완료취소</button>
                        @endif -->
                    @elseif ($timeDiff && $contentsList[0]->class_status >= 1 && $reportNeedYn)
                        <button class="btn btn-primary" type="button"  id="reportButton">활동일지작성</button>
                    @endif
                    {{-- <button class="btn btn-primary" type="button"  id="updateButton">수정</button> --}}
                    <button class="btn btn-primary" type="button"  id="listButton">목록</button>
                </div>
            </div>
        </div>
@endsection

@section('scripts')


    <!-- Custom scripts for all pages-->
    <script>

        $(document).ready(function() {

            var params = "?perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchType={{$searchType}}&searchWord={{$searchWord}}&searchToDate={{$searchToDate}}&searchFromDate={{$searchFromDate}}";

            $("#updateButton").click(function(){
                location.href='{{ route('grade.mylecture.update')}}' + params +"&id={{$contract->id}}";
            });

            $("#listButton").click(function(){
                location.href='{{ route('grade.mylecture.list')}}' + params ;
            });

            $("#finishButton").click(function(){
                if(confirm( '강의차수 및 수업방식 등의 정보가 정확한지 꼭 확인해 주세요.\r\n잘못된 정보가 있다면 수업완료 처리전에 관리자에게 문의해 주세요.\r\n\r\n' +$(this).text() + ' 처리 하시겠습니까?')){
                    var status_code = $(this).data('status');
                    $.ajax({
                        type : "post",
                        url : "{{ route('grade.mylecture.updateClassStatus') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'id' : '{{ $contract->id }}',
                            'class_status' : status_code,
                        },
                        success : function(data){
                            alert(data.msg);
                            location.reload();
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    });
                }
            });

            $("#resetButton").click(function(){
                if(confirm( $(this).text() + ' 처리 하시겠습니까?')){
                    var status_code = $(this).data('status');
                    $.ajax({
                        type : "post",
                        url : "{{ route('grade.mylecture.updateClassReset') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'id' : '{{ $contract->id }}',
                            'class_status' : status_code,
                        },
                        success : function(data){
                            alert(data.msg);
                            location.reload();
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    });
                }
            });


            $("#reportButton").click(function(){
                location.href='{{ route('grade.acreport.create')}}' + "?id={{$contract->id}}";
            });

        });

    </script>


@endsection
