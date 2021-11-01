@extends('layouts.main_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm" action="{{route('mgmt.contract.createDo') }}" onsubmit="return searchFormSubmit();" method="post" >
        @csrf

        <input type="hidden" name="classTargetList" id="classTargetList" value="">
        <input type="hidden" name="client_id" value="{{ $client->id}}">
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
                                <th ><span class="text-danger">*</span>담당자</th>
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
                                            <select name="status" id="status" class="form-control ">
                                                @foreach($commonCode as $code)
                                                    <option value="{{$code->code_id}}">{{$code->code_value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <th>세출 재료비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="outcome_material_cost" type="number" class="form-control @error('outcome_material_cost') is-invalid @enderror" name="outcome_material_cost" value=""  >
                                        </div>
                                    </div>
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
                    <table class="table-sm" id="" cellspacing="0" style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:90px;"><span class="text-danger">*</span>활동일자</th>
                                <th style="width:80px;"><span class="text-danger">*</span>시간</th>
                                <th style="width:145px;"><span class="text-danger">*</span>프로그램</th>
                                <th style="width:100px;"><span class="text-danger"></span>세부프로그램</th>
                                <th style="width:90px;"><span class="text-danger">*</span>교육대상</th>
                                <th style="width:45px;"><span class="text-danger">*</span>인원</th>
                                <th style="width:45px;"><span class="text-danger">*</span>횟수</th>
                                <th style="width:45px;"><span class="text-danger">*</span>차수</th>
                                <th style="width:50px;"><span class="text-danger">*</span>주강사</th>
                                <th style="width:45px;"><span class="text-danger">*</span>보조</th>
                                <th style="width:110px;"><span class="text-danger">*</span>주재원</th>
                                <th style="width:110px;"><span class="text-danger">*</span>보조재원</th>
                                <th style="width:110px;"><span class="text-danger">*</span>수업방식</th>
                                <th style="width:75px;"><span class="text-danger">*</span>수업구분</th>
                                <th style="width:50px;">
                                    <div class="row">
                                        <div class="col-md-12 input-group-sm">
                                            <input class="btn-sm btn-primary" type="button" name="addClass" id="addClassButton" value="추가">
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="classList" class="thead-light classList" style="border-bottom: 1px solid #dee2e6;">

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
            data-class_sub_name="${class_sub_name}"
            data-class_target="${class_target}"
            data-class_number="${class_number}"
            data-class_count="${class_count}"
            data-class_order="${class_order}"
            data-main_count="${main_count}"
            data-sub_count="${sub_count}"
            data-finance="${finance}"
            data-finance="${sub_finance}"
            data-class_type="${class_type}"
            data-class_type="${online_type}"  >

            <td style="width:100px;">${class_day}</td>
            <td style="width:100px;">${time_from}-${time_to}</td>
            <td style="width:160px;">${class_category_text}</td>
            <td style="width:120px;">${class_sub_name}</td>
            <td style="width:160px;">${class_target}</td>
            <td style="width:40px;">${class_number}</td>
            <td style="width:40px;">${class_count}</td>
            <td style="width:40px;">${class_order}</td>
            <td style="width:40px;">${main_count}</td>
            <td style="width:40px;">${sub_count}</td>
            <td style="width:40px;">${finance}</td>
            <td style="width:40px;">${sub_finance}</td>
            <td style="width:120px;">${class_type_text}</td>
            <td style="width:120px;">${online_type_text}</td>
            <td style="width:50px;"><button class="btn-sm btn-primary delRow" type="button">삭제</button></td>
        </tr>
    </script>


    <script id="tmpCclassTr" type="text/jquery-template">
        <tr class="classTarget">
            <td>
                <div class="row">
                    <div class="col-md-11 input-group-sm">
                        <input  type="text" class="form-control datepicker class_day" name="cclassList[].class_day" autocomplete='off' placeholder="yyyy-mm-dd"  required/>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-6 input-group-sm" style="padding-right: 2px;">
                        <input type="text" class="form-control time_from" name="cclassList[].time_from" value="09:00"  autocomplete='off' placeholder="00:00" required>
                    </div>
                    <div class="col-md-6 input-group-sm" style="padding-left: 2px;">
                         <input type="text" class="form-control time_to" name="cclassList[].time_to" value="10:00" autocomplete='off' placeholder="00:00" required>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <select name="cclassList[].class_category_id"  class="form-control class_category_id">
                            <option value="000">선택</option>
                            @foreach($classItems as $code)
                                <option value="{{$code->id}}">{{$code->class_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <input type="text" name="cclassList[].class_sub_name" class="form-control class_sub_name" value="" autocomplete='off'>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <input type="text" class="form-control class_target" name="cclassList[].class_target" value="" autocomplete='off' required>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-11 input-group-sm">
                        <input type="text" class="form-control class_number" name="cclassList[].class_number" value=""  autocomplete='off' required>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-11 input-group-sm">
                        <input type="text" class="form-control class_count" name="cclassList[].class_count" value="" autocomplete='off' required>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-11 input-group-sm">
                        <input  type="text" class="form-control class_order" name="cclassList[].class_order" value="" autocomplete='off' required>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-11 input-group-sm">
                        <input type="text" class="form-control main_count" name="cclassList[].main_count" value="" autocomplete='off' required>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-11 input-group-sm">
                        <input type="text" class="form-control sub_count" name="cclassList[].sub_count" value="" autocomplete='off' required>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <select name="cclassList[].finance"  class="form-control finance">
                            @foreach($financeList as $code)
                                <option value="{{$code->code_id}}">{{$code->code_value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <select name="cclassList[].sub_finance"  class="form-control sub_finance">
                            <option value="">해당없음</option>
                            @foreach($financeList as $code)
                                <option value="{{$code->code_id}}">{{$code->code_value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <select name="cclassList[].class_type" class="form-control class_type">
                            <option value="0">오프라인</option>
                            <option value="1">온라인 실시간</option>
                            <option value="2">온라인 동영상</option>
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <select name="cclassList[].online_type" class="form-control online_type" style="display: none">
                            <option value="0">최초</option>
                            <option value="1">재방</option>
                        </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 input-group-sm">
                        <button class="btn-sm btn-primary delRow" id="deleteRowButton" type="button">삭제</button>
                    </div>
                </div>
            </td>
        </tr>
    </script>


    <!-- Custom scripts for all pages-->
    <script>

        var $madeIndex = 0;
        var $commIndex = 0;


        $(document).ready(function() {

            $('.datepicker').datepicker(
                {
                    showButtonPanel: false
                }
            );

            $("#cancelButton").click(function(){
                location.href='{{ route('mgmt.client.list')}}' ;
            });

            $("#class_type").change(function(){
                if($("#class_type option:selected","#classList").val()==2){
                    $("#online_type","#classList").show();
                }else{
                    $("#online_type","#classList").hide();
                }
            });



            $("#addClassButton").click(function(){

                var data ={madeIndex:$madeIndex};
			    var newRow = $("#tmpCclassTr").tmpl(data);
			    var thisIndex = $madeIndex;


                $("input[name='cclassList[].class_day']", newRow).datepicker({
                    dateFormat: 'yy-mm-dd',	//날짜 포맷이다. 보통 yy-mm-dd 를 많이 사용하는것 같다.
                    changeMonth : true,
                    changeYear : true,
                    yearRange: 'c-100:c+10',
                    prevText: '이전 달',	// 마우스 오버시 이전달 텍스트
                    nextText: '다음 달',	// 마우스 오버시 다음달 텍스트
                    closeText: '닫기', // 닫기 버튼 텍스트 변경
                    currentText: '오늘', // 오늘 텍스트 변경
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],	//한글 캘린더중 월 표시를 위한 부분
                    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],	//한글 캘린더 중 월 표시를 위한 부분
                    dayNames: ['일', '월', '화', '수', '목', '금', '토'],	//한글 캘린더 요일 표시 부분
                    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],	//한글 요일 표시 부분
                    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],	// 한글 요일 표시 부분
                    showMonthAfterYear: true,	// true : 년 월  false : 월 년 순으로 보여줌
                    yearSuffix: '',
                });
                $(newRow)
                .on("click", "#deleteRowButton", function(event){
                    this.closest("tr").remove();})
                .on("change","select[name='cclassList[].class_type']", function(event){
				    var $select = $(this),
						selItem = $select.val();
                        if(selItem==2){
                            $("select[name='cclassList[].online_type']", newRow).show();
                        }else{
                            $("select[name='cclassList[].online_type']", newRow).hide();
                        }
                    });

                $("tbody.classList").append(newRow);

                $madeIndex++;
            });

            $("#addClass").click(function(){

                var _class_day          =$("#class_day","#classList").val();
                var _time_from          =$("#time_from","#classList").val();
                var _time_to            =$("#time_to","#classList").val();
                var _class_category_id   =$("#class_category_id option:selected","#classList").val();
                var _class_category_text=$("#class_category_id option:selected","#classList").text();
                var _class_sub_name     =$("#class_sub_name","#classList").val();
                var _class_target       =$("#class_target","#classList").val();
                var _class_number       =$("#class_number","#classList").val();
                var _class_count        =$("#class_count","#classList").val();
                var _class_order        =$("#class_order","#classList").val();
                var _main_count         =$("#main_count","#classList").val();
                var _sub_count          =$("#sub_count","#classList").val();

                var _finance          =$("#finance option:selected","#classList").val();
                var _sub_finance          =$("#sub_finance option:selected","#classList").val();

                var _class_type         =$("#class_type option:selected","#classList").val();
                var _class_type_text    =$("#class_type option:selected","#classList").text();

                var _online_type         =$("#online_type option:selected","#classList").val();
                var _online_type_text    =$("#online_type option:selected","#classList").text();
                if(_class_type!=2){
                    _online_type_text ="";
                }



                if(_class_day == "" || _time_from=="" || _time_to=="" || _class_target=="" || _class_number=="" || _class_count=="" || _class_order=="" || _main_count=="" || _sub_count=="" || _finance==""|| _sub_finance=="") {
                    alert('필수 항목을 모두 입력해 주세요.');
                    return false;
                }

                var defaultItem = {
					class_day           : _class_day
					,time_from          :_time_from
                    ,time_to            :_time_to
					,class_category_id  :_class_category_id
                    ,class_category_text:_class_category_text
					,class_sub_name     :_class_sub_name
                    ,class_target       :_class_target
                    ,class_number       :_class_number
                    ,class_count        :_class_count
                    ,class_order        :_class_order
                    ,main_count         :_main_count
                    ,sub_count          :_sub_count
                    ,finance            :_finance
                    ,sub_finance            :_sub_finance
                    ,class_type         :_class_type
                    ,class_type_text    :_class_type_text
                    ,online_type        :_online_type
                    ,online_type_text   :_online_type_text
			    }

                $("#tmpClassTr").tmpl(defaultItem).appendTo($("#classList"))
				.on("click",".delRow", function(e){
					this.closest("tr").remove();
				}).data('userData',defaultItem);

                $("#time_from","#classList").val("");
                $("#time_to","#classList").val("");
            });

            searchFormSubmit = function(){

                var checkDateFlag = true;
                var checkClassCateFlag = true;
                var checkClassNumber = true;
                var checkClassCount = true;
                var checkClassOrder = true;
                var checkMainCount = true;
                var checkSubCount = true;


                var classList = [];
			    $("tr.classTarget").each(function(){

                    var _class_day          =$(this).find(".class_day").val();
                    

                    var _time_from          =$(this).find(".time_from","#classList").val();
                    var _time_to            =$(this).find(".time_to","#classList").val();
                    var _class_category_id   =$(this).find(".class_category_id option:selected","#classList").val();
                    var _class_category_text=$(this).find(".class_category_id option:selected","#classList").text();
                    var _class_sub_name     =$(this).find(".class_sub_name","#classList").val();
                    var _class_target       =$(this).find(".class_target","#classList").val();
                    var _class_number       =$(this).find(".class_number","#classList").val();
                    if(!$.isNumeric(_class_number)) checkClassNumber = false;

                    var _class_count        =$(this).find(".class_count","#classList").val();
                    if(!$.isNumeric(_class_count)) checkClassCount = false;

                    var _class_order        =$(this).find(".class_order","#classList").val();
                    if(!$.isNumeric(_class_order)) checkClassOrder = false;

                    var _main_count         =$(this).find(".main_count","#classList").val();
                    if(!$.isNumeric(_main_count)) checkMainCount = false;

                    var _sub_count          =$(this).find(".sub_count","#classList").val();
                    if(!$.isNumeric(_sub_count)) checkSubCount = false;

                    var _finance          =$(this).find(".finance  option:selected","#classList").val();
                    var _sub_finance          =$(this).find(".sub_finance  option:selected","#classList").val();
                    var _class_type         =$(this).find(".class_type option:selected","#classList").val();
                    var _class_type_text    =$(".class_type option:selected","#classList").text();
                    var _online_type         =$(this).find(".online_type option:selected","#classList").val();
                    var _online_type_text    =$(this).find(".online_type option:selected","#classList").text();
                    if(_class_type!=2){
                        _online_type_text ="";
                    }

                    if(!checkValidDate(_class_day)){
                        checkDateFlag = false;
                    }
                    
                    if(_class_category_id=="000"){
                        checkClassCateFlag = false;
                    }

                    var defaultItem = {
                        class_day           : _class_day
                        ,time_from          :_time_from
                        ,time_to            :_time_to
                        ,class_category_id  :_class_category_id
                        ,class_category_text:_class_category_text
                        ,class_sub_name     :_class_sub_name
                        ,class_target       :_class_target
                        ,class_number       :_class_number
                        ,class_count        :_class_count
                        ,class_order        :_class_order
                        ,main_count         :_main_count
                        ,sub_count          :_sub_count
                        ,finance            :_finance
                        ,sub_finance            :_sub_finance
                        ,class_type         :_class_type
                        ,class_type_text    :_class_type_text
                        ,online_type        :_online_type
                        ,online_type_text   :_online_type_text
                    }
                    classList.push(defaultItem);
                   
                });

                //$("#classTargetList").val(JSON.stringify(classList));

                if(checkDateFlag && checkClassCateFlag && checkClassNumber && checkClassCount && checkClassOrder && checkMainCount && checkSubCount){
                    $("#classTargetList").val(JSON.stringify(classList));
                    return true;
                }else{

                    if(!checkDateFlag){
                        alert('활동일자가 올바르지 않습니다. 포멧에(yyyy-mm-dd) 맞게 입력해 주세요.');
                    }else if(!checkClassCateFlag){
                        alert('프로그램을 선택해 주세요.');
                    }else if(!checkClassNumber){
                        alert('인원값이 올바르지 않습니다. 확인해 주세요.');
                    }else if(!checkClassCount){
                        alert('횟수 값이 올바르지 않습니다. 확인해 주세요.');
                    }else if(!checkClassOrder){
                        alert('차수 값이 올바르지 않습니다. 확인해 주세요.');
                    }else if(!checkMainCount){
                        alert('주강사 값이 올바르지 않습니다. 확인해 주세요.');
                    }else if(!checkSubCount){
                        alert('보조강사 값이 올바르지 않습니다. 확인해 주세요.');
                    }
                    return false;
                }
                
            }


            checkValidDate = function(value) {
                var result = true;
                try {
                    var date = value.split("-");
                    var sy = date[0],
                        sm = date[1],
                        sd = date[2];
                    
                    if(sy.length != 4 || sm.length !=2 || sd.length !=2) {
                        return false;
                    }

                    var y = parseInt(date[0], 10),
                        m = parseInt(date[1], 10),
                        d = parseInt(date[2], 10);
                    
                    var dateRegex = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
                    result = dateRegex.test(d+'-'+m+'-'+y);
                } catch (err) {
                    result = false;
                }    
                return result;
            }

            $("#addClassButton").trigger("click");
        });
    </script>
@endsection
