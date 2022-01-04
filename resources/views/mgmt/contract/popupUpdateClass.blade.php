
<meta name="csrf-token" content="{{ csrf_token() }}">

<form name="modalForm" id="modalForm">
@csrf
    <input type="hidden" name="class_id" value="{{$class_id}}">
    <input type="hidden" name="contract_id" value="{{$contract_id}}">

<div class="modal" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">수업완료 수정</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            
            <div class="table">
                <table class="table-sm" id="" cellspacing="0" style="width: 100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:100px;"><span class="text-danger">*</span>활동일자</th>
                            <td style="width:130px;"> 
                                <div class="row">
                                    <div class="col-md-12 input-group-sm" > 
                                        <input  type="text" class="form-control datepicker class_day" name="class_day" value="{{$classList->class_day}}" />
                                    </div>
                                </div>
                            </td>
                            <th style="width:100px;"><span class="text-danger">*</span>시간</th>
                            <td style="width:130px;"> 
                                <div class="row">
                                    <div class="col-md-6 input-group-sm" style="padding-right: 2px;">
                                        <input type="text" class="form-control time_from" name="time_from" value="{{$classList->time_from}}"  autocomplete='off' placeholder="00:00" required>
                                    </div>
                                    <div class="col-md-6 input-group-sm" style="padding-left: 2px;">
                                        <input type="text" class="form-control time_to" name="time_to" value="{{$classList->time_to}}" autocomplete='off' placeholder="00:00" required>
                                    </div>
                                </div>
                            </td>
                            <th style="width:100px;"><span class="text-danger">*</span>프로그램</th>
                            <td style="width:160px;"> 
                                <div class="row">
                                    <div class="col-lg-12 input-group-sm">
                                        <input  type="hidden" class="form-control" name="class_category_id" value="{{$classList->class_category_id}}" />{{$classList->class_name}}
                                    </div>
                                </div>
                            </td>
                            <th style="width:100px;"><span class="text-danger"></span>세부프로그램</th>
                            <td style="width:160px;"> 
                                <div class="row">
                                    <div class="col-md-12 input-group-sm">
                                        <input  type="text" class="form-control" name="class_sub_name" value="{{$classList->class_sub_name}}" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:100px;"><span class="text-danger">*</span>교육대상</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                        <input  type="text" class="form-control class_target" name="class_target" value="{{$classList->class_target}}" autocomplete='off' required />
                                    </div>
                                </div>
                            </td>
                            <th style="width:100px;"><span class="text-danger">*</span>인원</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                    <input  type="text" class="form-control class_number" name="class_number" value="{{$classList->class_number}}" autocomplete='off' required />
                                    </div>
                                </div>
                            </td>
                            <th style="width:45px;"><span class="text-danger">*</span>횟수</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                    <input  type="text" class="form-control class_count" name="class_count" value="{{$classList->class_count}}" autocomplete='off' required />
                                    </div>
                                </div>
                            </td>
                            <th style="width:45px;"><span class="text-danger">*</span>차수</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                    <input  type="text" class="form-control class_order" name="class_order" value="{{$classList->class_order}}" autocomplete='off' required />
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:50px;"><span class="text-danger">*</span>주강사</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                    <input  type="hidden" class="form-control" name="main_count" value="{{$classList->main_count}}" autocomplete='off'  />{{$classList->main_count}}
                                    </div>
                                </div>
                            </td>
                            <th style="width:45px;"><span class="text-danger">*</span>보조</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                    <input  type="hidden" class="form-control" name="sub_count" value="{{$classList->sub_count}}" autocomplete='off'  />{{$classList->sub_count}}
                                    </div>
                                </div>
                            </td>
                            <th style="width:110px;"><span class="text-danger">*</span>주재원</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                        <select name="finance"  class="form-control finance">
                                            @foreach($financeList as $code)
                                            <option value="{{$code->code_id}}" {{$classList->finance == $code->code_id ? 'selected':''}} >{{$code->code_value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <th style="width:110px;"><span class="text-danger">*</span>보조재원</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                        <select name="sub_finance"  class="form-control sub_finance">
                                            @if($classList->sub_count == 0)
                                            <option value="">해당없음</option>
                                            @endif
                                            @if($classList->sub_count > 0)
                                            @foreach($financeList as $code)
                                            <option value="{{$code->code_id}}" {{$classList->sub_finance == $code->code_id ? 'selected':''}} >{{$code->code_value}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="width:110px;"><span class="text-danger">*</span>수업방식</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                        <select name="class_type" id="class_type" class="form-control class_type">
                                            <option value="0" {{$classList->class_type == 0 ? 'selected' : ''}} > 오프라인</option>
                                            <option value="1" {{$classList->class_type == 1 ? 'selected' : ''}}> 온라인 실시간</option>
                                            <option value="2" {{$classList->class_type == 2 ? 'selected' : ''}}> 온라인 동영상</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <th style="width:75px;"><span class="text-danger">*</span>수업구분</th>
                            <td> 
                                <div class="row">
                                    <div class="col-md-11 input-group-sm">
                                        <select name="online_type" id="online_type" class="form-control online_type" style="display: {{$classList->class_type == 2 ? 'block' : 'none'}} ">
                                            <option value="0" {{$classList->online_type == 0 ? 'selected' : ''}} >최초</option>
                                            <option value="1" {{$classList->online_type == 1 ? 'selected' : ''}} >재방</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="classList" class="thead-light classList" style="border-bottom: 1px solid #dee2e6;">

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveButton">저장</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>
</form>


<script>

    $(document).ready(function() {

        
        $("input[name='class_day']").datepicker({
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


        $("#class_type").change(function(){
            if($("#class_type option:selected").val()==2){
                $("#online_type").show();
            }else{
                $("#online_type").hide();
            }
        });


        $("#saveButton").click(function(e){
            
            var checkDateFlag = true;
            var checkClassNumber = true;
            var checkClassCount = true;
            var checkClassOrder = true;

            
            var _class_day           =$("#modalForm").find(".class_day").val();
            if(!checkValidDate(_class_day)){
                checkDateFlag = false;
            }

            var checkClassTime = true;
            if($.trim($("#modalForm").find(".time_from").val()) == "") checkClassTime = false;
            if($.trim($("#modalForm").find(".time_to").val()) == "") checkClassTime = false;


            var checkClassTarget = true;
            if($.trim($("#modalForm").find(".class_target").val()) == "") checkClassTarget = false;

            var _class_number        =$("#modalForm").find(".class_number").val();
            if(!$.isNumeric(_class_number)) checkClassNumber = false;

            var _class_count        =$("#modalForm").find(".class_count").val();
            if(!$.isNumeric(_class_count)) checkClassCount = false;

            var _class_order        =$("#modalForm").find(".class_order").val();
            if(!$.isNumeric(_class_order)) checkClassOrder = false;


            if(checkDateFlag && checkClassNumber && checkClassCount && checkClassOrder && checkClassTarget && checkClassTime){

                if(confirm("수업완료 정보를 수정 하시겠습니까?")){

                    var params = $("#modalForm").serialize();
                    $.ajax({
                        type : "post",
                        url : "{{ route('mgmt.contract.popupUpdateClassDo') }}",
                        data : params,
                        success : function(data){
                            alert(data.msg);
                            location.reload();
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    });

                }
            } else{

                if(!checkDateFlag){
                    alert('활동일자가 올바르지 않습니다. 포멧에(yyyy-mm-dd) 맞게 입력해 주세요.');
                }else if(!checkClassNumber){
                    alert('인원값이 올바르지 않습니다. 확인해 주세요.');
                }else if(!checkClassCount){
                    alert('횟수 값이 올바르지 않습니다. 확인해 주세요.');
                }else if(!checkClassOrder){
                    alert('차수 값이 올바르지 않습니다. 확인해 주세요.');
                }else if(!checkClassTarget){
                    alert('교육대상을 입력해 주세요.');
                }else if(!checkClassTime){
                    alert('교육 시간을 입력해 주세요.')
                }
                return false;
            }
        });


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


    });

</script>

