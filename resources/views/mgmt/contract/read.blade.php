@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">계약등록</h1>

    <form name="searchForm" id="searchForm" action="{{route('mgmt.contract.createDo') }}" onsubmit="return searchFormSubmit();" method="post" >
        @csrf

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
                            <tr>
                                <th >담당자</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required >
                                        </div>
                                    </div>
                                </td>
                                <th >이메일</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value=""  >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>연락처</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value=""  >
                                        </div>
                                    </div>
                                </td>
                                <th>연락처</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="phone2" type="text" class="form-control @error('phone2') is-invalid @enderror" name="phone2" value=""  >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>회당 강사비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="class_cost" type="number" class="form-control @error('class_cost') is-invalid @enderror" name="class_cost" value="" >
                                        </div>
                                    </div>
                                </td>
                                <th>총 강사비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="class_total_cost" type="number" class="form-control @error('class_total_cost') is-invalid @enderror" name="class_total_cost" value="" >
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <th>인당 재료비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="material_cost" type="number" class="form-control @error('material_cost') is-invalid @enderror" name="material_cost" value=""  >
                                        </div>
                                    </div>
                                </td>
                                <th>총 재료비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="material_total_cost" type="number" class="form-control @error('material_total_cost') is-invalid @enderror" name="material_total_cost" value=""  >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>입금여부</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <select name="paid_yn" id="paid_yn" class="form-control ">
                                                <option value="0">미입금</option>
                                                <option value="1">입금완료</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <th>총비용</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="total_cost" type="number" class="form-control @error('total_cost') is-invalid @enderror" name="total_cost" value="" >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>진행상태</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">

                                        </div>
                                    </div>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <th>비고</th>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col-md-10 input-group-sm">
                                            <input id="comments" type="text" class="form-control" name="comments" value="" >
                                        </div>
                                    </div>
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
                    <table class="table-sm" id="" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:100px;">활동일자</th>
                                <th style="width:120px;">시간</th>
                                <th style="width:160px;">프로그램</th>
                                <th style="width:160px;">교육대상</th>
                                <th style="width:80px;">인원</th>
                                <th style="width:80px;">횟수</th>
                                <th style="width:80px;">차수</th>
                                <th style="width:80px;">주강사수</th>
                                <th style="width:80px;">보조강사수</th>
                                <th style="width:100px;">온오프</th>
                                <th style="width:100px;"></th>
                            </tr>
                        </thead>
                        <tbody id="classList" class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-10 input-group-sm">
                                            <input id="class_day" type="text" class="form-control datepicker @error('class_day') is-invalid @enderror" name="class_day" value="" required >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="time_from" type="text" class="form-control input-group-sm @error('time_from') is-invalid @enderror" name="time_from" value=""  >
                                            <input id="time_to" type="text" class="form-control input-group-sm @error('time_to') is-invalid @enderror" name="time_to" value="" >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12 input-group-sm">
                                            <select name="class_category_id" id="class_category_id" class="form-control ">

                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12 input-group-sm">
                                            <input id="class_target" type="text" class="form-control @error('class_target') is-invalid @enderror" name="class_target" value=""  >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-7 input-group-sm">
                                            <input id="class_number" type="number" class="form-control @error('class_number') is-invalid @enderror" name="class_number" value=""  >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-7 input-group-sm">
                                            <input id="class_count" type="number" class="form-control @error('class_count') is-invalid @enderror" name="class_count" value="1" >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-7 input-group-sm">
                                            <input id="class_order" type="number" class="form-control @error('class_order') is-invalid @enderror" name="class_order" value="1" >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-7 input-group-sm">
                                            <input id="main_count" type="number" class="form-control @error('main_count') is-invalid @enderror" name="main_count" value="1" >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-7 input-group-sm">
                                            <input id="sub_count" type="number" class="form-control @error('sub_count') is-invalid @enderror" name="sub_count" value="0" >
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12 input-group-sm">
                                            <select name="class_type" id="class_type" class="form-control ">
                                                <option value="0">오프라인</option>
                                                <option value="1">온라인</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12 input-group-sm">
                                            <input class="btn-sm btn-primary" type="button" name="addClass" id="addClass" value="추가">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row-fluid" style="text-align: right;">
                    <button class="btn btn-primary" type="submit"  id="saveButton">저장</button>
                    <button class="btn btn-primary" type="button"  id="cancelButton">취소</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')

    <script src="{{asset('js/memo/jquery.tmpl.min.js')}}"></script>

    <script id="tmpClassTr" type="text/jquery-template">
        <tr class="classTarget"
            data-class_day="${class_day}"
            data-time_from="${time_from}"
            data-time_to="${time_to}"
            data-class_day="${class_day}"
            data-class_category_id="${class_category_id}"
            data-class_target="${class_target}"
            data-class_number="${class_number}"
            data-class_count="${class_count}"
            data-class_order="${class_order}"
            data-main_count="${main_count}"
            data-sub_count="${sub_count}"
            data-class_type="${class_type}"  >

            <td style="width:100px;">${class_day}</td>
            <td style="width:120px;">${time_from}-${time_to}</td>
            <td style="width:160px;">${class_category_text}</td>
            <td style="width:160px;">${class_target}</td>
            <td style="width:80px;">${class_number}</td>
            <td style="width:80px;">${class_count}</td>
            <td style="width:80px;">${class_order}</td>
            <td style="width:80px;">${main_count}</td>
            <td style="width:80px;">${sub_count}</td>
            <td style="width:100px;">${class_type_text}</td>
            <td style="width:100px;"><button class="btn-sm btn-primary delRow" type="button">삭제</button></td>
        </tr>
    </script>

    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {

            $madeIndex=0;

            $('.datepicker').datepicker(
                {
                    showButtonPanel: false
                }
            );

            $("#listButton").click(function(){
                location.href='{{ route('mgmt.client.list')}}' + params ;
            });

            $("#updateButton").click(function(){
                location.href='{{ route('mgmt.client.update')}}' + params +"&id={{ $client->id}}";
            });

            $("#addClass").click(function(){

                var _class_day          =$("#class_day","#classList").val();
                var _time_from          =$("#time_from","#classList").val();
                var _time_to            =$("#time_to","#classList").val();
                var _class_category_id   =$("#class_category_id option:selected","#classList").val();
                var _class_category_text=$("#class_category_id option:selected","#classList").text();
                var _class_target       =$("#class_target","#classList").val();
                var _class_number       =$("#class_number","#classList").val();
                var _class_count        =$("#class_count","#classList").val();
                var _class_order        =$("#class_order","#classList").val();
                var _main_count         =$("#main_count","#classList").val();
                var _sub_count          =$("#sub_count","#classList").val();
                var _class_type         =$("#class_type option:selected","#classList").val();
                var _class_type_text    =$("#class_type option:selected","#classList").text();

                var defaultItem = {
					class_day           : _class_day
					,time_from          :_time_from
                    ,time_to            :_time_to
					,class_category_id  :_class_category_id
                    ,class_category_text:_class_category_text
					,class_target       :_class_target
                    ,class_number       :_class_number
                    ,class_count        :_class_count
                    ,class_order        :_class_order
                    ,main_count         :_main_count
                    ,sub_count          :_sub_count
                    ,class_type         :_class_type
                    ,class_type_text    :_class_type_text
					,madeIndex          :$madeIndex
			    }

                $("#tmpClassTr").tmpl(defaultItem).appendTo($("#classList"))
				.on("click",".delRow", function(e){
					this.closest("tr").remove();
				}).data('userData',defaultItem);
                $madeIndex++;

                $("#time_from","#classList").val("");
                $("#time_to","#classList").val("");
            });

            searchFormSubmit = function(){

                var classList = [];
			    $("tr.classTarget").each(function(){
                    classList.push($(this).data("userData"));
                });

                $("#classTargetList").val(JSON.stringify(classList));

                return true;
            }


        });
    </script>
@endsection