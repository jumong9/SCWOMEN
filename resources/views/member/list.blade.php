@extends('layouts.layout_admin')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">BBS</h6>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="" id="dataTable_length">
                    <label>Show
                        <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> entries
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                <div id="dataTable_filter" class="">
                    <label>Search:
                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>이름</th>
                            <th>E-mail</th>
                            <th>기수</th>
                            <th>상태</th>
                            <th>구분</th>
                            <th>강사단</th>
                            <th>과목</th>
                            <th>등록일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userlist as $key => $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->group }}</td>
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
                            <td>{{ $member->classCategories[0]->class_gubun}}</td>
                            <td>{{ $member->classCategories[0]->class_name}}</td>
                            <td>{{ $member->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a class="btn btn-primary btn-sm fa-pull-right" href="">등록</a>
            {{ $userlist->links() }}
        </div>
    </div>
@endsection

@section('scripts')




    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
