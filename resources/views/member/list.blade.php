@extends('layouts.layout_admin')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                <div class="input-group">
                    <select class="custom-select-sm" id="" style="width:77px;" >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <input type="text" class="col-xs-2 form-control bg-light form-control-sm" placeholder="Search for...">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
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
