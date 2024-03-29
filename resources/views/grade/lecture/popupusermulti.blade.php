
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">강사 팝업</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="container-fluid">
                <div class="row" id="userList">
                    <div class="col-md-6 select-outline">

                        <label>주강사</label>
                        <select class="col-md-11 mdb-select md-form md-outline" name="main_user" id="main_user" size="10">
                            @foreach($userList as $user)
                                <option value="{{$user->user_id}}_{{$user->class_category_id}}" >{{$user->group}}기 {{$user->user_name}} {{$user->user_status == 2? '강사' : '프리랜서'}} ( 주 {{$user->main_count}}회  보조 {{$user->sub_count}}회 )</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6 select-outline ml-auto">
                        <label>보조강사</label>
                        <select class="col-md-11 mdb-select md-form md-outline" name="sub_user" id="sub_user" multiple size="10">
                            @foreach($userList as $user)
                                <option value="{{$user->user_id}}_{{$user->class_category_id}}" >{{$user->group}}기 {{$user->user_name}} {{$user->user_status == 2? '강사' : '프리랜서'}} ( 주 {{$user->main_count}}회  보조 {{$user->sub_count}}회 )</option>
                            @endforeach
                        </select>
                        <br>Ctrl키를 누른 상태로 멀티 선택/해제 가능
                    </div>
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
            var main_user_id = $("#main_user option:selected","#userList").val();
            var sub_user_id = $("#sub_user","#userList").val();

            if($("#main_user option:selected","#userList").length==0){
                alert('주강사를 선택해 주세요.');
                return false;
            }

            if($.inArray(main_user_id, sub_user_id) >= 0){
                alert('주강사로 선택한 강사는 보조강사에 선택 할 수 없습니다.');
                return false;
            }

            $.ajax({
                type : "post",
                url : "{{ route('grade.lecture.updateUserMulti') }}",
                data : {
                    _token: "{{csrf_token()}}",
                    'main_user_id' : main_user_id,
                    'sub_user_id' : sub_user_id,
                    'contract_class_id' : '{{$contract_class_id}}',
                },
                success : function(data){
                    alert(data.msg);
                    location.reload();
                },
                error : function(xhr, exMessage) {
                    alert('error');
                },
            });
        });

    });

</script>



