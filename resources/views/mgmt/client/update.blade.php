@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">강사관리</h1>

    <form name="searchForm" id="searchForm" action="{{route('mgmt.client.updateDo') }}" onsubmit="return searchFormSubmit();" method="post" >
    @csrf
        <input type="hidden" name="id" value="{{ $client->id}}">
        <input type="hidden" name="searchType" value="{{ $searchType }}">
        <input type="hidden" name="searchWord" value="{{ $searchWord }}">
        <input type="hidden" name="searchStatus" value="{{ $searchStatus }}">
        <input type="hidden" name="perPage" value="{{ $perPage }}">
        <input type="hidden" name="page" value="{{ $page }}">

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
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $client->name }}" required >
                                    </div>
                                </div>
                            </td>
                            <th>구분</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="gubun" id="gubun" class="form-control">
                                            @foreach($commonCode as $code)
                                            <option value="{{$code->code_id}}" {{ $client->code_id == $code->code_id ? "selected" : "" }}>{{$code->code_value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>대표전화</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_tel" value="{{ $client->client_tel }}"  >
                                    </div>
                                </div>
                            </td>
                            <th>대표팩스</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_fax" value="{{ $client->client_fax }}"  >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>행정실전화</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="office_tel" type="text" class="form-control @error('office_tel') is-invalid @enderror" name="office_tel" value="{{ $client->office_tel }}" >
                                    </div>
                                </div>
                            </td>
                            <th>행정실팩스</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="office_fax" type="text" class="form-control @error('office_fax') is-invalid @enderror" name="office_fax" value="{{ $client->office_fax }}" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>주소지</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input id="address" type="text" class="form-control" name="address" value="{{ $client->address }}" >
                                    </div>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="submit"  id="saveButton">저장</button>
                <button class="btn btn-primary" type="button"  id="cancelButton">취소</button>
            </div>
        </div>
    </div>
    </form>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {


            var params = "?perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchType={{$searchType}}&searchWord={{$searchWord}}";

            searchFormSubmit = function(){
                return true;
            }

            $("#cancelButton").click(function(){
                location.href='{{ route('mgmt.client.read')}}'  + params +"&id={{$client->id}}";
            });


            $('.datepicker').datepicker(
                {
                    showButtonPanel: false
                }
            );

            $("#searchForm").validate({
                rules: {
                    name: {
                        required:true
                    }
                },
                messages : {
                    name: {
                        required : '수요처명을 입력해 주세요.'
                    }
                }
            });
        });
    </script>
@endsection
