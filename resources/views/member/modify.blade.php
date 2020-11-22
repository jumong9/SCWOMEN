@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">강사관리</h1>

    <form name="searchForm" id="searchForm" action="{{route('member.update') }}" onsubmit="return searchFormSubmit();" method="post" >
    @csrf
        <input type="hidden" name="id" value="{{ $member[0]->id}}">
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
                            <th>강사명</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $member[0]->name }}" required >
                                    </div>
                                </div>
                            </td>
                            <th>상태</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="status" id="status" class="form-control">
                                            <option value="0" {{ $member[0]->status == 0 ? "selected" : "" }}>승인대기</option>
                                            <option value="2" {{ $member[0]->status == 2 ? "selected" : "" }}>활동중</option>
                                            <option value="4" {{ $member[0]->status == 4 ? "selected" : "" }}>프리랜서</option>
                                            <option value="6" {{ $member[0]->status == 6 ? "selected" : "" }}>활동보류</option>
                                            <option value="8" {{ $member[0]->status == 8 ? "selected" : "" }}>활동중단</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>핸드폰</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $member[0]->mobile }}" required >
                                    </div>
                                </div>
                            </td>
                            <th>구분</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="gubun" id="gubun" class="form-control">
                                            <option value="0" {{ $member[0]->gubun == 0 ? "selected" : "" }}>내부</option>
                                            <option value="2" {{ $member[0]->gubun == 2 ? "selected" : "" }}>외부</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $member[0]->email }}" required >
                                    </div>
                                </div>
                            </td>
                            <th>기수</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="group" type="text" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ $member[0]->group }}" required >
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th>생년월일</th>
                            <td>
                                <input id="birthday" type="text" class="form-control col-md-6 datepicker" readonly name="birthday" value="{{ $member[0]->birthday }}" >
                            </td>
                            <th>등록일</th>
                            <td>{{ $member[0]->created_at}}</td>
                        </tr>
                        <tr>
                            <th>주소지</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-10">
                                        <input id="address" type="text" class="form-control" name="address" value="{{ $member[0]->address }}" >
                                    </div>
                                </div>
                            </td>

                            <th>입단일</th>
                            <td>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="joinday" type="text" class="form-control datepicker" readonly name="joinday" value="{{ $member[0]->joinday }}" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="display:none;" class="stopday">
                            <th>보류/중단일</th>
                            <td >
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="stopday" type="text" class="form-control datepicker" readonly name="stopday" value="{{ $member[0]->stopday }}" >
                                    </div>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>강사단명</th>
                            <td colspan="3">
                                <div class="row">
                                @foreach($classItems as $item)
                                    <div class="form-check pl-5 pr-3">
                                        <input id="class_category_id_{{ $item->id }}" name="class_category_id[]" class="form-check-input" type="checkbox" value="{{ $item->id }} ">
                                        <label class="form-check-label" for="class_category_id_{{ $item->id }}"> {{ $item->class_name }} </label>
                                    </div>
                                @endforeach
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="submit"  id="saveButton">저장</button>
                <button class="btn btn-primary" type="button"  id="cancelButton">취소</button>
                {{-- <button class="btn btn-primary" type="button"  id="listButton">목록</button> --}}
            </div>
        </div>
    </div>
    </form>
@endsection

@section('scripts')
    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {

            checkMyClass = function(){
                @foreach($member[0]->classCategories as $category)
                    $("#class_category_id_"+{{ $category->id }}).attr("checked", true);
                @endforeach
            }

            showStopday = function(){
                if(6 == '{{ $member[0]->status}}' || 8 == '{{ $member[0]->status}}'){
                    $(".stopday").show();
                }
            }

            $("#status").change(function(){
                var selItem = $("select[name=status]").val();
                if(selItem == 6 || selItem == 8 ){
                    $(".stopday").show();
                }else{
                    $(".stopday").hide();
                    $("#stopday").val("");
                }

            });


            var params = "?id={{$member[0]->id}}&perPage={{$perPage}}&page={{$page}}&searchStatus={{$searchStatus}}&searchType={{$searchType}}&searchWord={{$searchWord}}";

            searchFormSubmit = function(){
                //action="{{route('member.list') }}"
                return true;
            }



            $("#cancelButton").click(function(){
                location.href='{{ route('member.detail')}}' + params;
            });

            $("#listButton").click(function(){
                location.href='{{ route('member.list')}}' + params;
            });

            $('.datepicker').datepicker(
                {
                    showButtonPanel: false
                }
            );

            checkMyClass();

            showStopday();

        });
    </script>
@endsection
