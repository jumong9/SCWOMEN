@extends('layouts.main_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm" action="{{route('mgmt.client.createDo') }}" onsubmit="return searchFormSubmit();" method="post" >
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table">
                <table class="table" id="" cellspacing="0">
                    <colgroup>
                        <col width="200px">
                        <col width="40%">
                        <col width="200px">
                        <col width="40%">
                    </colgroup>
                    <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                        <tr>
                            <th>수요처명</th>
                            <td>
                                {{ $client->name }}
                            </td>
                            <th>구분</th>
                            <td>
                                {{ $client->client_gubun_value }}
                            </td>
                        </tr>
                        <tr>
                            <th>대표전화</th>
                            <td>
                                {{ $client->client_tel }}
                            </td>
                            <th>대표팩스</th>
                            <td>
                                {{ $client->client_fax }}
                            </td>
                        </tr>
                        <tr>
                            <th>행정실전화</th>
                            <td>
                                {{ $client->office_tel }}
                            </td>
                            <th>행정실팩스</th>
                            <td>
                                {{ $client->office_fax }}
                            </td>
                        </tr>
                        <tr>
                            <th>주소지</th>
                            <td>
                                {{ $client->zipcode }} {{ $client->address }}
                            </td>
                            <th>지역구분</th>
                            <td>{{ $client->client_loctype_value }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button"  id="updateButton">수정</button>
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

            $("#listButton").click(function(){
                location.href='{{ route('mgmt.client.list')}}' + params ;
            });

            $("#updateButton").click(function(){
                location.href='{{ route('mgmt.client.update')}}' + params +"&id={{ $client->id}}";
            });


        });
    </script>
@endsection
