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
                             --}}
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
                                <th style="width:160px;">교육대상</th>
                                <th style="width:80px;">인원</th>
                                <th style="width:80px;">횟수</th>
                                <th style="width:80px;">차수</th>
                                <th style="width:80px;">주강사수</th>
                                <th style="width:80px;">보조강사수</th>
                                <th style="width:80px;">재료비</th>
                                <th style="width:100px;">수업방식</th>
                                <th style="width:100px;">구분</th>
                            </tr>
                        </thead>
                        <tbody id="classList" class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            @foreach($contentsList as $key => $list)
                            <tr>
                                <td>
                                    {{$list->class_status == 0? '미완료' : '완료'}}
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


        <span>활동일지 등록</span>
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table">
                    <table class="table" id="" width="100%" cellspacing="0">
                        <colgroup>
                            <col width="200px">
                            <col width="40%">
                            <col width="200px">
                            <col width="40%">
                        </colgroup>
                        <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            <tr>
                                <th>교육시간</th>
                                <td>
                                    {{$calssReport->time_from}} - {{$calssReport->time_to}}
                                </td>
                                <th>교육장소</th>
                                <td>
                                    {{$calssReport->class_place}}
                                </td>
                            </tr>
                            <tr>
                                <th>교육내용</th>
                                <td colspan="3">
                                    {!! nl2br($calssReport->class_contents) !!}
                                </td>
                            </tr>
                            <tr>
                                <th>강사소견 및 평가</th>
                                <td colspan="3">
                                    {!! nl2br($calssReport->class_rating) !!}
                                </td>
                            </tr>
                            <tr>
                                <th>사진자료</th>
                                <td colspan="3">
                                    {{-- {{ $fileInfo[0]->file_real_name }} --}}
                                <img src="{{ asset($fileInfo[0]->file_path.'/'.$fileInfo[0]->file_name)}}" width="300" height="200">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row-fluid" style="text-align: right;">
                    <button class="btn btn-primary" type="button"  id="listButton">목록</button>
                </div>
            </div>
        </div>

@endsection

@section('scripts')


    <!-- Custom scripts for all pages-->
    <script>

        $(document).ready(function() {

            var params = "?perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchType={{$searchType}}&searchWord={{$searchWord}}&searcFromDate={{$searcFromDate}}&searcToDate={{$searcToDate}}";

            $("#listButton").click(function(){
                location.href='{{ route('mgmt.acreport.list')}}' + params;
            });

        });

    </script>


@endsection
