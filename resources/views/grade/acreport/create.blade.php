@extends('layouts.main_layout')

@section('content')

<div id="modalFrame"></div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm" action="{{route('grade.acreport.createDo') }}" onsubmit="return searchFormSubmit();" method="post" enctype="multipart/form-data" >
        @csrf

        <input type="hidden" name="contract_class_id" value="{{ $contentsList[0]->id }}">
        <input type="hidden" name="finance_type" value="{{ $contentsList[0]->finance_type }}">
        <input type="hidden" name="class_category_id" value="{{ $contentsList[0]->class_category_id }}">
        <input type="hidden" name="class_day" value="{{ $contentsList[0]->class_day }}">

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
                                <th><span class="text-danger">*</span>교육시간</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2 input-group-sm" style="padding-right: 2px;">
                                            <input id="time_from" type="text" class="form-control @error('time_from') is-invalid @enderror" name="time_from" value="{{$contentsList[0]->time_from}}" required >
                                        </div>
                                        <div class="col-md-2 input-group-sm" style="padding-left: 2px;">
                                             <input id="time_to" type="text" class="form-control @error('time_to') is-invalid @enderror" name="time_to" value="{{$contentsList[0]->time_to}}" required>
                                        </div>
                                    </div>
                                </td>
                                <th><span class="text-danger">*</span>교육대상</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input id="class_place" type="text" class="form-control @error('class_place') is-invalid @enderror" name="class_place" value="{{$contentsList[0]->class_target}}" required >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><span class="text-danger">*</span>교육내용</th>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <textarea class="form-control" id="class_contents" name="class_contents" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><span class="text-danger">*</span>강사소견 및 평가</th>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <textarea class="form-control" id="class_rating" name="class_rating" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><span class="text-danger">*</span>사진자료</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="file" class="form-control-file" id="upload_file" name="upload_file" required>
                                            @error('upload_file')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </td>
                                <th>보조강사</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="sub_user_names" name="sub_user_names" value="@foreach($lectorsList as $key => $list){{$list->name}}@if(!$loop->last),@endif @endforeach">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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

            var params = "?perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchType={{$searchType}}&searchWord={{$searchWord}}";

            searchFormSubmit = function(){

                $("#createButton")
                    .prop("disabled", true)
                    .html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);

                return true;
            }

            $("#createButton").click(function(){
                return true;
            });

            $("#calcelButton").click(function(){
                location.href='{{ route('grade.mylecture.read')}}' + params +"&id={{$contract->id}}";
            });

            $("#class_type").change(function(){
                if($(this).val() == 2 ) {
                    $(".online_type").show();
                }else{
                    $(".online_type").hide();
                }
            });


        });

    </script>


@endsection
