
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                    <div class="col-md-5 select-outline">

                        <label>주강사 {{ $userList[0]->class_main_count}}명 배정가능</label>
                        <select class="col-md-11 mdb-select md-form md-outline" name="main_user" id="main_user" size="5">
                            @foreach($userList as $user)
                                @php $selItem="";@endphp
                                @foreach($selectedUser as $selUser)
                                    @if($user->user_id == $selUser->user_id && $selUser->main_yn==1)
                                        @php $selItem ="selected";@endphp
                                    @endif
                                @endforeach
                                <option value="{{$user->user_id}}_{{$user->class_category_id}}" {{$selItem}}>{{$user->group}}기 {{$user->user_name}} {{$user->user_status == 2? '강사' : '프리랜서'}} ( 주 {{$user->main_count}}회  보조 {{$user->sub_count}}회 )</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-5 select-outline ml-auto">
                        <label>강사단 선택</label>
                        <select class="col-md-11 mdb-select md-form md-outline" name="class_cate" id="class_cate" onchange="getUserLists();" @if($userList[0]->class_sub_count==0) disabled @endif size="5">

                                @foreach($classItems as $sel)

                                    <option value="{{$sel->id}}" @if($sel->id == $cateId)) selected @endif>{{$sel->class_name}}</option>
                                @endforeach

                        </select>
                    </div>

                    <div class="col-md-5 select-outline ml-auto">
                        <label>보조강사 {{ $userList[0]->class_sub_count}}명 배정가능</label>
                        <select class="col-md-11 mdb-select md-form md-outline" name="sub_user" id="sub_user" @if( $userList[0]->class_sub_count==0) disabled @endif multiple size="5">
                                @foreach($selectedUser as $selUser)
                                    @if($selUser->user_id && $selUser->main_yn==0)
                                        <option value="{{$selUser->user_id}}_{{$selUser->class_category_id}}" >{{$selUser->group}}기 {{$selUser->user_name}} {{$selUser->user_status == 2? '강사' : '프리랜서'}} ( 주 {{$selUser->main_count}}회  보조 {{$selUser->sub_count}}회 )</option>
                                    @endif
                                @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 select-outline">
                        <button type="button" class="btn-sm btn-primary mt-5 mb-1" id="addUser">보조강사 추가</button>
                        <button type="button" class="btn-sm btn-primary" id="delUser">보조강사 삭제</button>
                    </div>

                    <div class="col-md-5 select-outline ml-auto">
                        <label>강사목록</label>
                        <select class="col-md-11 mdb-select md-form md-outline" name="sub_user_list" id="sub_user_list" @if( $userList[0]->class_sub_count==0) disabled @endif size="5">
                            @foreach($userList as $user)
                                <option value="{{$user->user_id}}_{{$user->class_category_id}}">{{$user->group}}기 {{$user->user_name}} {{$user->user_status == 2? '강사' : '프리랜서'}} ( 주 {{$user->main_count}}회  보조 {{$user->sub_count}}회 )</option>
                            @endforeach
                        </select>
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

        getUserLists = function(){
            var class_category_id = $("#class_cate").val();
            $.ajax({
                type : "post",
                url : "{{ route('grade.lecture.allUserList') }}",
                data : {
                    _token: "{{csrf_token()}}",
                    'class_category_id' : class_category_id,
                },
                success : function(data){
                    $("#sub_user_list").empty();
                    $.each(data.userList, function(idx, val){
                        var in_val = val.user_id+"_"+val.class_category_id;
                        var show_lec = (val.user_status == 2)?"강사": "프리랜서";
                        var out_val = val.group+"기 "+ val.user_name + " " + show_lec + " ( 주"+val.main_count+"회 보조 " + val.sub_count+"회 )";

                        var option = "<option value='"+in_val+"' >" +out_val+ "</option>";
                        $('#sub_user_list').append(option);
                    });

                },
                error : function(xhr, exMessage) {
                    console.log(xhr);
                    alert('error');
                },
            });
        }


        $("#addUser").click(function(){

            if($("#sub_user_list option:selected").length == 0){
                alert("추가할 사용자를 선택해 주세요.");
                return false;
            }


            var sel_val = $("#sub_user_list option:selected").val();
            var sel_text = $("#sub_user_list option:selected").text();

            if($("#sub_user option[value='"+sel_val+"']").length !=0 ) {
                alert("이미 등록된 사용자가 있습니다.");
                return false;
            }

            var option = "<option value='"+sel_val+"' >" +sel_text+ "</option>";
            $('#sub_user').append(option);
        });


        $("#delUser").click(function(){
            if($("#sub_user option:selected").length == 0){
                alert("삭제할 사용자를 선택해 주세요.");
                return false;
            }
            $('#sub_user option:selected').remove();
        });


        $("#saveButton").click(function(e){
            //$("#sub_user").find("option").attr('selected','selected');
            $("#sub_user").find("option").prop('selected',true);
            var main_user_id = $("#main_user option:selected","#userList").val();
            var sub_user_id = $("#sub_user","#userList").val();

            if($("#main_user option:selected","#userList").length==0){
                alert('주강사를 선택해 주세요.');
                return false;
            }

            var sel_sub_count =$("#sub_user","#userList").find("option").length;
            var can_sub_count = '{{$userList[0]->class_sub_count}}';


            if($.inArray(main_user_id, sub_user_id) >= 0){
                alert('주강사로 선택한 강사는 보조강사에 선택 할 수 없습니다.');
                return false;
            }

            if(sel_sub_count != can_sub_count){
                alert('보조강사를 배정수에 맞게 선택해 주세요.');
                return false;
            }

            if(confirm("강사 등록을 하시겠습니까?")){


                $.ajax({
                    type : "post",
                    url : "{{ route('grade.lecture.updateUser') }}",
                    data : {
                        _token: "{{csrf_token()}}",
                        'main_user_id' : main_user_id,
                        'sub_user_id' : sub_user_id,
                        'contract_class_id' : '{{$class_id}}',
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



