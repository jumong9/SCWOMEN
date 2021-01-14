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
                            <th><span class="text-danger">*</span>수요처명</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required >
                                    </div>
                                </div>
                            </td>
                            <th><span class="text-danger">*</span>구분</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="gubun" id="gubun" class="form-control">
                                            @foreach($commonCode as $code)
                                            <option value="{{$code->code_id}}">{{$code->code_value}}</option>
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
                                        <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_tel" value=""  >
                                    </div>
                                </div>
                            </td>
                            <th>대표팩스</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_fax" value=""  >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>행정실전화</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="office_tel" type="text" class="form-control @error('office_tel') is-invalid @enderror" name="office_tel" value="" >
                                    </div>
                                </div>
                            </td>
                            <th>행정실팩스</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="office_fax" type="text" class="form-control @error('office_fax') is-invalid @enderror" name="office_fax" value="" >
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th>주소지</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input id="zipcode" type="text" class="form-control postcodify_postcode5 @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}"  >
                                    </div>
                                        <button class="btn btn-primary" type="button"  id="postcodify_search_button">조회</button>
                                    <div class="col-md-10 mt-1">
                                        <input id="address" type="text" class="form-control postcodify_address" name="address" value="" >
                                    </div>
                                </div>
                            </td>
                            <th><span class="text-danger">*</span>지역구분</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="client_loctype" id="client_loctype" class="form-control">
                                            @foreach($codeLoclist as $code)
                                            <option value="{{$code->code_id}}">{{$code->code_value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-10 mt-1 client_loctype_etc" style="display:none;">
                                        <input id="client_loctype_etc" type="text" class="form-control postcodify_address" name="client_loctype_etc" value="" >
                                    </div>
                                </div>
                            </td>
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
<script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
<script> $(function() { $("#postcodify_search_button").postcodifyPopUp(); }); </script>
    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {


            {{--
            var params = "?perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchType={{$searchType}}&searchWord={{$searchWord}}";
        --}}
            searchFormSubmit = function(){
                return true;
            }

            $("#client_loctype").change(function(){
                var selItem = $("select[name=client_loctype]").val();
                if(selItem == 99 ){
                    $(".client_loctype_etc").show();
                }else{
                    $(".client_loctype_etc").hide();
                    $("#client_loctype_etc").val("");
                }

            });


            $("#cancelButton").click(function(){
                location.href='{{ route('mgmt.client.list')}}' ;
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
                        required : '이름을 입력해 주세요.'
                    }
                }
            });
        });
    </script>
@endsection
