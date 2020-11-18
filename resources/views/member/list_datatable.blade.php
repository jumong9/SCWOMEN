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


                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <!-- Page level plugins -->
    <script src="{{ asset('sba/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sba/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "responsive": true,
                "length": 3,
               // "pagingType" : "full_numbers",
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ route('member.list') }}",
                    "data":{ _token: "{{csrf_token()}}"},
                    "dataType": "json",
                    "dataSrc":function(res){
                        return res.data;
                    }
                },
                "columns": [
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "group" },
                    { "data": "grade" },
                    { "data": "gubun" },
                    { "data": "class_name" },
                    { "data": "class_gubun" },
                    { "data": "created_at" }
                ]
            });
        });
    </script>
@endsection
