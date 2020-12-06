@extends('layouts.ad_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm"  action="{{route('mgmt.acreport.list') }}" method="post" >
        <input name="checkedItemId" type="hidden" value=""/>
    @csrf
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <div class="float-left">
                <div class="form-inline">
                    <select name="perPage" id="perPage" class="form-control float-left mr-2">
                        <option value="5" {{$classList->perPage() == 5 ? "selected" : "" }} >5</option>
                        <option value="10" {{$classList->perPage() == 10 ? "selected" : "" }}>10</option>
                        <option value="30" {{$classList->perPage() == 30 ? "selected" : "" }}>30</option>
                        <option value="50" {{$classList->perPage() == 50 ? "selected" : "" }}>50</option>
                    </select>
                    <span >전체 {{ $classList->total() }} 건</span>
                </div>
            </div>
            <div class="float-right">
                <div class="form-inline">
                    <div class="form-group mb-2">
                        {{--
                        <select class="form-control" name="searchType" id="searchType">
                            <option value="">선택하세요</option>
                            <option value="name" {{ $searchType == 'name' ? "selected" : "" }} >이름</option>
                            <option value="group" {{ $searchType == 'group' ? "selected" : "" }} >기수</option>
                        </select>
                        --}}
                        <input type="text" class="form-control" id="searchWord" name="searchWord" value="{{ $searchWord }}" placeholder="수요처명">
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
                            <th>
                                <input type="checkbox" id="selectAllCheck">
                            </th>
                            <th>활동일자</th>
                            <th>시간</th>
                            <th>수요처</th>
                            <th>프로그램</th>
                            <th>진행방식</th>
                            <th>교육대상</th>
                            <th>인원</th>
                            <th>작성자</th>
                            <th>등록일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classList as $key => $list)
                        <tr>
                            <td>
                                <input type="checkbox" name="id" id="id" value="{{ $list->id }}" >
                            </td>
                            <td>{{ $list->class_day,'Y-m-d'}}</td>
                            <td>{{ $list->time_from}} - {{ $list->time_to}}</td>
                            <td>{{ $list->client_name}}</td>
                            <td><a href="{{ route ('grade.acreport.read', ['id'=>$list->id, 'perPage'=>$classList->perPage(), 'page'=>$classList->currentPage(), 'searchStatus'=>$searchStatus, 'searchType' => $searchType, 'searchWord' => $searchWord ]) }}">{{ $list->class_name }} </a></td>
                            <td>
                                @switch($list->class_type)
                                    @case(0)
                                        오프라인
                                        @break
                                    @case(2)
                                        온라인 실시간
                                        @break
                                    @case(3)
                                        온라인 동영상
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $list->class_target}}</td>
                            <td>{{ $list->class_number}}</td>
                            <td>{{ $list->created_name}}</td>
                            <td>{{ $list->updated_at,'Y-m-d' }}</td>
                        @endforeach
                    </tbody>
                </table>
                {{ $classList->withQueryString()->links() }}
            </div>
            <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button" name="printButton" id="printButton">선택출력</button>
            </div>
        </div>
    </div>
    </form>
    <form name="winopen" id="winopen" action="{{route('mgmt.acreport.list') }}" method="post">
        @csrf
        <input type="hidden" name="ids" id="ids" value="12,1">
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

            $("#selectAllCheck").click(function(){
                if($("#selectAllCheck").prop("checked")) {
                    $("input[type=checkbox]").prop("checked",true);
                } else {
                    $("input[type=checkbox]").prop("checked",false);
                }

            });


            $("#printButton").click(function(e){

                if($("input:checkbox[name=id]:checked").length == 0){
                    alert("대상을 선택해 주세요.")
                    return false;
                }

                var ids = [];
                $("input:checkbox[name=id]:checked").each(function(){
                    ids.push($(this).val());
                });
                $("#ids").val(ids.join(","));

                var url = '{{ route('mgmt.acreport.list') }}';

                if( /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor) ){
                    window.open(url, "winopen");
                }else{
                    window.open(url, "winopen", "resizable=yes,toolbar=yes,menubar=yes,location=yes");
                }

                form.submit();

            });



        });
    </script>
@endsection
