@extends('layouts.main_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">강사승인관리</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.application.list') }}" method="post" >
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
                            <td>{{ $member[0]->name }}</td>
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
                            <td>{{ $classCategory[0]->user_group}}</td>

                        </tr>
                        <tr>
                            <th>생년월일</th>
                            <td>{{ $member[0]->birthday}}</td>

                            <th>등록일</th>
                            <td>{{ $member[0]->created_at}}</td>
                        </tr>
                        <tr>
                            <th>주소지</th>
                            <td>{{ $member[0]->address}}</td>
                            <th>입단일</th>
                            <td>{{ $classCategory[0]->joinday}}</td>
                        </tr>
                        @if ($member[0]->status == 6 || $member[0]->status ==9)
                        <tr >
                            <th>보류/중단일</th>
                            <td>{{ $member[0]->stopday}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <tr>
                            <th>강사단명</th>
                            <td colspan="3">
                                @foreach($classCategory as $category)
                                    {{ $category->class_name }}( 주 : {{ $category->main_count }}, 보조 : {{ $category->sub_count }} ) @if(!$loop->last), @endif
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row-fluid" style="text-align: right;">
                @if($member[0]->status==0)
                    <button class="btn btn-primary" type="button"  id="approvalButton">승인</button>
                @endif
                    <button class="btn btn-primary" type="button"  id="updateButton">수정</button>
                    <button class="btn btn-primary" type="button"  id="deleteButton">삭제</button>
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
            var params = "?perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchType={{$searchType}}&searchWord={{$searchWord}}";

            //승인처리
            $("#approvalButton").click(function(){

                if(confirm("승인 처리 하시겠습니까?")){
                    $.ajax({
                        type : "post",
                        url : "{{ route('mgmt.application.approval') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'checkedItemId' : {{ $member[0]->id }}
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
                        url : "{{ route('mgmt.application.delete') }}",
                        data : {
                            _token: "{{csrf_token()}}",
                            'checkedItemId' : {{ $member[0]->id }}
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
                location.href='{{ route('mgmt.application.update')}}' + params +"&id={{ $member[0]->id}}";
            });

            $("#listButton").click(function(){
                location.href='{{ route('mgmt.application.list')}}' + params;
            });


        });
    </script>
@endsection
