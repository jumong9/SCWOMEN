@extends('layouts.main_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">강사승인관리</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.application.list') }}" method="post" >
        <input name="checkedItemId" type="hidden" value=""/>
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <div class="float-left">
                <div class="form-inline">
                    <select name="perPage" id="perPage" class="form-control float-left mr-2">
                        <option value="5" {{$userlist->perPage() == 5 ? "selected" : "" }} >5</option>
                        <option value="10" {{$userlist->perPage() == 10 ? "selected" : "" }}>10</option>
                        <option value="30" {{$userlist->perPage() == 30 ? "selected" : "" }}>30</option>
                        <option value="50" {{$userlist->perPage() == 50 ? "selected" : "" }}>50</option>
                    </select>
                    <span >전체 {{ $userlist->total() }} 건</span>
                </div>
            </div>
            <div class="float-right">
                <div class="form-inline">
                    <div class="form-group">
                        {{-- <select class="form-control" name="searchStatus" id="searchStatus">
                            <option value="99" {{ $searchStatus == 99 ? "selected" : "" }} >전체</option>
                            <option value="0" {{ $searchStatus == 0 ? "selected" : "" }} >승인대기</option>
                            <option value="2" {{ $searchStatus == 2 ? "selected" : "" }} >활동중</option>
                            <option value="4" {{ $searchStatus == 4 ? "selected" : "" }} >프리랜서</option>
                            <option value="6" {{ $searchStatus == 6 ? "selected" : "" }} >활동보류</option>
                            <option value="8" {{ $searchStatus == 8 ? "selected" : "" }} >활동중단</option>
                        </select>
                        <select class="form-control" name="searchType" id="searchType">
                            <option value="">선택하세요</option>
                            <option value="name" {{ $searchType == 'name' ? "selected" : "" }} >이름</option>
                            <option value="group" {{ $searchType == 'group' ? "selected" : "" }} >기수</option>
                        </select> --}}
                        <input type="text" class="form-control" id="searchWord" name="searchWord" value="{{ $searchWord }}" placeholder="강사명" >
                        <button type="button" name="searchButton" id="searchButton" class="btn btn-primary ml-2">검색</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                @if($searchStatus == 0)
                                    <input type="checkbox" id="selectAllCheck">
                                @endif
                            </th>
                            <th>구분</th>
                            <th>기수</th>
                            <th>강사명</th>
                            <th>강사단명</th>
                            <th>핸드폰</th>
                            <th>E-mail</th>
                            <th>상태</th>
                            <th>등록일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userlist as $key => $member)
                        <tr>
                            <td>
                                @if($searchStatus == 0)
                                    <input type="checkbox" name="id" value="{{ $member->id }}">
                                @endif
                            </td>
                            <td>
                                @switch($member->gubun)
                                    @case(0)
                                        내부
                                        @break
                                    @case(2)
                                        외부
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>{{ $member->user_group }}</td>
                            <td><a href="{{ route ('mgmt.application.read', ['id'=>$member->id, 'perPage'=>$userlist->perPage(), 'page'=>$userlist->currentPage(), 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $member->name }}</a></td>
                            <td>{{ $member->class_name}}</td>
                            <td>{{ $member->mobile }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                @switch($member->status)
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
                            <td>{{ $member->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $userlist->withQueryString()->links() }}
            </div>
            <div class="row-fluid" style="text-align: right;">
                @if($searchStatus == 0)
                    <button class="btn btn-primary" type="button" name="approvalButton" id="approvalButton">승인</button>
                @endif
            </div>
        </div>
    </div>
    </form>
@endsection

@section('scripts')
    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {

            $("#perPage").change(function(){
                $("#searchButton").trigger("click");
            });

            $("#searchButton").click(function(){
                $("#searchForm").submit();
            });

            $("#selectAllCheck").click(function(){
                if($("#selectAllCheck").prop("checked")) {
                    $("input[type=checkbox]").prop("checked",true);
                } else {
                    $("input[type=checkbox]").prop("checked",false);
                }

            });

            //승인처리
            $("#approvalButton").click(function(){

                var chkcnt = $("input:checkbox[name=id]:checked").length;
                var ids = [];
                if(chkcnt < 1){
                    alert('승인 대상을 선택해 주세요.');
                    return false;
                }else{

                    $("input:checkbox[name=id]:checked").each(function(){
                        ids.push($(this).val());
                    });
                    $("input[name=checkedItemId]").val(ids);

                    if(confirm("승인 처리 하시겠습니까?")){
                        $.ajax({
                            type : "post",
                            url : "{{ route('mgmt.application.approval') }}",
                            data : {
                                _token: "{{csrf_token()}}",
                                'checkedItemId' : $("input[name=checkedItemId]").val()
                            },
                            success : function(data){
                                alert(data.msg);
                                $("#searchButton").trigger("click");
                            },
                            error : function(xhr, exMessage) {
                               alert('error');
                            },
                        })
                    }
                }
            });


        });
    </script>
@endsection
