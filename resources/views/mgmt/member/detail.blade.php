@extends('layouts.main_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">강사관리</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.member.list') }}" method="post" >
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table " id="" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="200px">
                        <col width="40%">
                        <col width="200px">
                        <col width="40%">
                    </colgroup>
                    <tbody class="thead-light" style="border-bottom: 1px solid #dee2e6;">
                        <tr>
                            <th>강사명</th>
                            <td>{{ $member[0]->name }} &nbsp;<button class="btn btn-primary btn-sm" type="button"  id="passwdButton">비밀번호 초기화</button></td>
                            <th>상태</th>
                            <td>
                                @switch($member[0]->status)
                                    @case(0)
                                        승인대기
                                        @break
                                    @case(2)
                                        활동중
                                        @break
                                    @case(4)
                                        프리랜서
                                        @break
                                    @case(6)
                                        활동보류
                                        @break
                                    @case(8)
                                        활동중단
                                        @break
                                    @default
                                @endswitch
                            </td>

                        </tr>
                        <tr>
                            <th>핸드폰</th>
                            <td>{{ $member[0]->mobile }}</td>
                            <th>구분</th>
                            <td>
                                @switch($member[0]->gubun)
                                    @case(0)
                                        내부
                                        @break
                                    @case(2)
                                        외부
                                        @break
                                    @default
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td>{{ $member[0]->email }}</td>
                            <th>기수</th>
                            <td>{{ $member[0]->group }}</td>

                        </tr>
                        <tr>
                            <th>생년월일</th>
                            <td>{{ $member[0]->birthday}}</td>

                            <th>등록일</th>
                            <td>{{ $member[0]->created_at}}</td>
                        </tr>
                        <tr>
                            <th>주소지</th>
                            <td>{{ $member[0]->zipcode}} {{ $member[0]->address}}</td>
                            <th>입단일</th>
                            <td>{{ $classCategory->joinday}}</td>
                        </tr>
                        <tr >
                            <th>등급</th>
                            <td>{{ $classCategory->user_grade == 0 ? '일반강사' : '반장강사' }}
                                @if ($classCategory->user_grade == 0 )
                                    &nbsp;<button class="btn btn-primary btn-sm" type="button"  id="leaderButton">반장강사로 변경</button>
                                @endif
                                @if ($classCategory->user_grade == 10 )
                                    &nbsp;<button class="btn btn-primary btn-sm" type="button"  id="normalButton">일반강사로 변경</button>
                                @endif
                            </td>
                            @if ($member[0]->status == 6 || $member[0]->status ==9)
                            <th>보류/중단일</th>
                            <td>{{ $member[0]->stopday}}</td>
                            @else
                            <td></td>
                            <td></td>
                            @endif
                        </tr>

                        <tr>
                            <th>강사단명</th>
                            <td colspan="3">
                                {{-- @foreach($classCategory as $category)
                                    {{ $category->class_name }}( 주 : {{ $category->main_count }}, 보조 : {{ $category->sub_count }} ) @if(!$loop->last), @endif
                                @endforeach --}}
                                {{ $classCategory->class_name }}( 주 : {{ $classCategory->main_count }}, 보조 : {{ $classCategory->sub_count }} )
                            </td>
                        </tr>
                        @foreach($userHistory as $key => $history)
                        <tr>
                            <th>비고</th>
                            <td colspan="3">
                                {{ $history->created_at}} : {{ $history->comments }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row-fluid" style="text-align: right;">
                @if($member[0]->status==0)
                    <button class="btn btn-primary" type="button"  id="approvalButton">승인</button>
                @endif
                    <button class="btn btn-primary" type="button"  id="updateButton">수정</button>
                    {{--<button class="btn btn-primary" type="button"  id="deleteButton">삭제</button>--}}
                    <button class="btn btn-primary" type="button"  id="listButton">목록</button>
            </div>
        </div>
    </div>
    </form>
@endsection

@section('scripts')
    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {
            var params = "?perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchGrade={{$searchGrade}}&searchType={{$searchType}}&searchWord={{$searchWord}}";

            $("#passwdButton").click(function(){
                if(confirm("비밀번호를 초기화 하시겠습니까?")){
                    $.ajax({
                        type : "post",
                        url : "{{ route('mgmt.member.resetPasswd') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'checkedItemId' : {{ $member[0]->id }},
                            'birthday' : '{{ $member[0]->birthday}}',
                        },
                        success : function(data){
                            alert(data.msg);
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    })
                }
            });

            $("#leaderButton").click(function(){
                if(confirm("반장 강사로 변경 하시겠습니까?")){
                    $.ajax({
                        type : "post",
                        url : "{{ route('mgmt.member.updateClassCategory') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'checkedItemId' : {{ $member[0]->id }},
                            'grade' : 10,
                            'cate_id' : {{$classCategory->class_category_id}},
                        },
                        success : function(data){
                            alert(data.msg);
                            location.reload();
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    })
                }
            });

            $("#normalButton").click(function(){
                if(confirm("일반 강사로 변경 하시겠습니까?")){
                    $.ajax({
                        type : "post",
                        url : "{{ route('mgmt.member.updateClassCategory') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'checkedItemId' : {{ $member[0]->id }},
                            'grade' : 0,
                            'cate_id' : {{$classCategory->class_category_id}},
                        },
                        success : function(data){
                            alert(data.msg);
                            location.reload();
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    })
                }
            });

            $("#approvalButton").click(function(){

                if(confirm("승인 처리 하시겠습니까?")){
                    $.ajax({
                        type : "post",
                        url : "{{ route('mgmt.member.updateApproval') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'checkedItemId' : {{ $member[0]->id }},
                            'cate_id' : {{$classCategory->class_category_id}},
                        },
                        success : function(data){
                            alert(data.msg);
                            location.reload();
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    })
                }
            });

            //반려 삭제 처리
            $("#deleteButton").click(function(){

                if(confirm("삭제 처리 하시겠습니까?")){
                    $.ajax({
                        type : "post",
                        url : "{{ route('mgmt.member.deleteUser') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'checkedItemId' : {{ $member[0]->id }},
                            'cate_id' : {{$classCategory->class_category_id}},
                        },
                        success : function(data){
                            alert(data.msg);
                            $("#listButton").trigger("click");
                        },
                        error : function(xhr, exMessage) {
                            alert('error');
                        },
                    })
                }
            });

            $("#updateButton").click(function(){
                location.href='{{ route('mgmt.member.modify')}}' + params +"&id={{ $member[0]->id}}" +"&cate_id={{ $member[0]->cate_id}}";
            });

            $("#listButton").click(function(){
                location.href='{{ route('mgmt.member.list')}}' + params;
            });


        });
    </script>
@endsection
