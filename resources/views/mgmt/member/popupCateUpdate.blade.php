
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal " id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">강사 파견 정보 수정</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div class="table">
                        <table class="table" id="" cellspacing="0">
                            <colgroup>
                                <col width="220px">
                                <col width="30%">
                                <col width="220px">
                                <col width="30%">
                            </colgroup>
                            <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                                <tr>
                                    <th>강사명</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                            {{ $member[0]->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <th>강사단명</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                            {{ $classCategory[0]->class_name }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>주강사횟수</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input id="main_count" type="text" class="form-control" name="main_count" value="{{ $classCategory[0]->main_count }}" require>
                                            </div>
                                        </div>
                                    </td>
                                    <th>보조강사횟수</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input id="sub_count" type="text" class="form-control" name="sub_count" value="{{ $classCategory[0]->sub_count }}" require>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveButton">저장</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function() {

        $("#saveButton").click(function(e){
            

            
            var main_count = $.trim($("#main_count").val());
            var sub_count = $.trim($("#sub_count").val());

            if(main_count=="") {
                alert('주강사 횟수를 입력해 주세요.');
                return false;
            }
            if(!$.isNumeric(main_count)) {
                alert('주강사 횟수는 숫자만 입력해 주세요.');
                return false;
            }
            if(sub_count=="") {
                alert('보조강사 횟수를 입력해 주세요.');
                return false;
            }
            if(!$.isNumeric(sub_count)) {
                alert('보조강사 횟수는 숫자만 입력해 주세요.');
                return false;
            }

            if(confirm("강사 파견 횟수를 수정 하시겠습니까?")){
                $.ajax({
                    type : "post",
                    url : "{{ route('mgmt.member.popupCateUpdateDo') }}",
                    data : {
                        _token: "{{csrf_token()}}",
                        'id' : {{ $classCategory[0]->id }},
                        'main_count' : main_count,
                        'sub_count' : sub_count,
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

    });

</script>



