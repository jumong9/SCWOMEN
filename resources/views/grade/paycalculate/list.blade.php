@extends('layouts.main_layout')

@section('content')
    <div id="modalFrame"></div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <form name="searchForm" id="searchForm"  action="{{route('grade.paycalculate.list') }}" method="post" >
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
                    <div class="form-group">
                        <select class="form-control" name="searchType" id="searchType">
                            <option value="xxx">선택하세요</option>
                            @foreach($financeList as $key => $code)
                                @if( $code->code_id != 4 && $code->code_id != 5)
                                <option value="{{$code->code_id}}" {{ $searchType == $code->code_id ? "selected" : "" }}>{{$code->code_value}}
                                        @endif
                                    
                                
                            @endforeach
                        </select>
                        <input style="width: 110px;" type="text" class="form-control datepickerm " id="searchFromMonth" name="searchFromMonth" value="{{ $searchFromMonth }}" placeholder="종료일">
                        <input type="text" class="form-control" id="searchWord" name="searchWord" value="{{ $searchWord }}" placeholder="수요처">
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
                            <th>강사명</th>
                            <th>활동일자</th>
                            <th>시간</th>
                            <th>자격</th>
                            <th>지급기준</th>
                            <th>기본시간</th>
                            <th>기본금액</th>
                            <th>추가시간</th>
                            <th>추가금액</th>
                            <th>총액</th>
                            <th>소득세</th>
                            <th>주민세</th>
                            <th>실지급액</th>
                            <th>강의방식</th>
                            <th>수요처</th>
                            <th>프로그램</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classList as $key => $list)
                            @if(empty($list->contract_id))
                                <tr>
                                    <td>{{ $list->user_name}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td> @if (empty($list->user_name) ) 총합계 @else 소계 @endif</td>
                                    <td>{{ number_format( $list->tot_cost ) }} </td>
                                    <td>{{ number_format( $list->i_tax ) }} </td>
                                    <td>{{ number_format( $list->r_tax ) }} </td>
                                    <td>{{ number_format( $list->calcu_cost ) }} </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $list->user_name}}</td>
                                    <td>{{ $list->class_day,'Y-m-d'}}</td>
                                    <td>{{ $list->lector_main_count + $list->lector_extra_count}}</td>
                                    <td>{{ $list->main_yn == 0 ? '보조강사' : '주강사' }}</td>
                                    <td>{{ $list->main_yn == 0 ? $list->my_sub_count : $list->my_main_count }}회</td>
                                    <td>{{ number_format($list->lector_main_count) }}</td>
                                    <td>{{ number_format($list->lector_main_cost) }}</td>
                                    <td>{{ number_format($list->lector_extra_count) }}</td>
                                    <td>{{ number_format($list->lector_extra_cost) }}</td>
                                    <td>{{ number_format( $list->tot_cost ) }} </td>
                                    <td>{{ number_format( $list->i_tax ) }} </td>
                                    <td>{{ number_format( $list->r_tax ) }} </td>
                                    <td>{{ number_format( $list->calcu_cost ) }} </td>
                                    <td>
                                        @if($list->class_type == 0)
                                            오프라인
                                        @elseif($list->class_type==1)
                                            온라인실시간
                                        @else
                                            온라인동영상 {{$list->online_type == 0 ? ' - 최초방영' : ' - 재방' }}
                                        @endif
                                    </td>
                                    <td>{{ $list->client_name}}</td>
                                    <td>{{ $list->class_gubun}} - {{ $list->class_name }}</td>
                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
                {{ $classList->withQueryString()->links() }}
            </div>
            <div class="row-fluid" style="text-align: right;">
                @if (count($classList) > 0)
                    <button class="btn btn-primary" type="button" name="exportExcelButton" id="exportExcelButton">엑셀다운로드</button>
                    <button class="btn btn-primary" type="button" name="printButton" id="printButton">지급조서출력</button>
                @endif
            </div>
        </div>
    </div>
    </form>
    <form target="printPopup" name="winopenOpen" id="winopenOpen" action="{{route('grade.paycalculate.popupPayDocument') }}" method="post">
        @csrf
        <input type="hidden" name="searchFromMonth" id="searchFromMonth" value="">
        <input type="hidden" name="searchWord" id="searchWord" value="">
        <input type="hidden" name="finance" id="finance" value="">
    </form>
@endsection

{{-- <script src="{{ asset('js/common_utils.js') }}"></script> --}}
@section('scripts')
    <!-- Custom scripts for all pages-->
    <script>
        $(document).ready(function() {

            // $.fn.loading = function(type) {
            //     $("body").append("<div class='text-center'><div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>");
            // }


            $('.datepickerm').datepicker( {
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy-mm',
                yearRange: 'c-10:c0',
                closeText: '닫기', // 닫기 버튼 텍스트 변경
                    currentText: '오늘', // 오늘 텍스트 변경
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],	//한글 캘린더중 월 표시를 위한 부분
                    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],	//한글 캘린더 중 월 표시를 위한 부분

                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            });

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

            $("#exportExcelButton").click(function(e){
                $("#searchForm").attr("action", "{{ route('grade.paycalculate.exportExcel') }}");
                $("#searchForm").submit();
                $("#searchForm").attr("action", "{{route('grade.paycalculate.list') }}");
            });

            $("#printButton").click(function(e){

                $("#searchFromMonth","#winopenOpen").val($("#searchFromMonth","#searchForm").val());
                $("#searchWord","#winopenOpen").val($("#searchWord","#searchForm").val());
                $("#finance","#winopenOpen").val($("select[name=searchType]","#searchForm").val());

                var url = '{{ route('grade.paycalculate.popupPayDocument') }}';

                if( /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor) ){
                    window.open('', "printPopup");
                }else{
                    window.open('', "printPopup", "resizable=yes,toolbar=yes,menubar=yes,location=yes");
                }

                document.getElementById('winopenOpen').submit();


            });

        });
    </script>
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@endsection
