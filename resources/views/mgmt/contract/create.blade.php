@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">계약등록</h1>

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
                                {{ $client->code_value }}
                            </td>
                        </tr>
                        {{--
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
                                {{ $client->address }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        --}}
                    </tbody>
                </table>
            </div>
            {{-- <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button"  id="updateButton">수정</button>
                <button class="btn btn-primary" type="button"  id="listButton">목록</button>
            </div> --}}
        </div>
    </div>

    <form name="searchForm" id="searchForm" action="{{route('mgmt.client.createDo') }}" onsubmit="return searchFormSubmit();" method="post" >
        @csrf
        <!-- DataTales Example -->
        <span>계약 기본정보</span>
        <div class="card shadow mb-4">

            <div class="card-body">
                <div class="table">
                    <table class="table-sm" id="" cellspacing="0">
                        <colgroup>
                            <col width="200px">
                            <col width="40%">
                            <col width="200px">
                            <col width="40%">
                        </colgroup>
                        <tbody class="thead-light " style="border-bottom: 1px solid #dee2e6;">
                            <tr>
                                <th >담당자</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required >
                                        </div>
                                    </div>
                                </td>
                                <th >이메일</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <select name="gubun" id="gubun" class="form-control ">

                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>연락처</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_tel" value=""  >
                                        </div>
                                    </div>
                                </td>
                                <th>연락처</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_fax" value=""  >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>회당 강사비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="office_tel" type="text" class="form-control @error('office_tel') is-invalid @enderror" name="office_tel" value="" >
                                        </div>
                                    </div>
                                </td>
                                <th>총 강사비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="office_fax" type="text" class="form-control @error('office_fax') is-invalid @enderror" name="office_fax" value="" >
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <th>인당 재료비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_tel" value=""  >
                                        </div>
                                    </div>
                                </td>
                                <th>총 재료비</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="client_tel" type="text" class="form-control @error('mobile') is-invalid @enderror" name="client_fax" value=""  >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>입금여부</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <select name="gubun" id="gubun" class="form-control ">
                                                <option value="N">미입금</option>
                                                <option value="N">입금완료</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <th>총비용</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <input id="office_fax" type="text" class="form-control @error('office_fax') is-invalid @enderror" name="office_fax" value="" >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>진행상태</th>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 input-group-sm">
                                            <select name="gubun" id="gubun" class="form-control ">
                                                <option value="N">미입금</option>
                                                <option value="N">입금완료</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <th>비고</th>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col-md-10 input-group-sm">
                                            <input id="address" type="text" class="form-control" name="address" value="" >
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

    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {



            $("#listButton").click(function(){
                location.href='{{ route('mgmt.client.list')}}' + params ;
            });

            $("#updateButton").click(function(){
                location.href='{{ route('mgmt.client.update')}}' + params +"&id={{ $client->id}}";
            });


        });
    </script>
@endsection
