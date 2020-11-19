@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>

    <form name="searchForm" id="searchForm"  action="{{route('member.list') }}" method="post" >
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <div class="float-left">
                <div class="form-inline">
                    <select name="perPage" id="perPage" class="form-control float-left mr-2">
                        <option value="5" {{ $userlist->perPage() == 5 ? "selected" : "" }} >5</option>
                        <option value="10" {{$userlist->perPage() == 10 ? "selected" : "" }}>10</option>
                        <option value="30" {{$userlist->perPage() == 30 ? "selected" : "" }}>30</option>
                        <option value="50" {{$userlist->perPage() == 50 ? "selected" : "" }}>50</option>
                    </select>
                    <span >전체 {{ $userlist->total() }} 건</span>
                </div>
            </div>
            <div class="float-right">
                <div class="form-inline">
                    <div class="form-group mb-2">
                        <select class="form-control" name="searchStatus" id="searchStatus">
                            <option>전체</option>
                            <option value="0">대기</option>
                            <option value="1">승인</option>
                        </select>
                        <select class="form-control" name="searchType" id="searchType">
                            <option>선택하세요</option>
                            <option value="name">이름</option>
                            <option value="group">기수</option>
                        </select>
                        <input type="text" class="form-control" id="searchWord" name="searchWord">
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
                            <th><input type="checkbox"></th>
                            <th>구분</th>
                            <th>기수</th>
                            <th>강사명</th>
                            <th>핸드폰</th>
                            <th>E-mail</th>
                            <th>강사단명</th>
                            <th>상태</th>
                            <th>등록일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userlist as $key => $member)
                        <tr>
                            <td><input type="checkbox" name="id" value="{{ $member->id }}<"></td>
                            <td>
                                @switch($member->gubun)
                                    @case(0)
                                        내부
                                        @break
                                    @case(1)
                                        외부
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>{{ $member->group }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->mobile }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->classCategories[0]->class_name}}</td>
                            <td>
                                @switch($member->grade)
                                    @case(0)
                                        승인대기중
                                        @break
                                    @case(1)
                                        승인완료
                                        @break
                                    @default
                                @endswitch
                            </td>
                            <td>{{ $member->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $userlist->links() }}
            </div>
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button" name="approvalButton" id="approvalButton">승인</button>
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

            $("#approvalButton").click(function(){
                alert('approvalButton');
            });


        });
    </script>
@endsection
