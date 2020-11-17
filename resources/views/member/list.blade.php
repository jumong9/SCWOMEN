@extends('layouts.layout_admin')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sba/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sba/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sba/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sba/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('sba/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sba/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
               // responsive: true
            });
        });
    </script>
@endsection
