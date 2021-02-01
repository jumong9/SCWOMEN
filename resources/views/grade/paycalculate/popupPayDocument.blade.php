<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel8') }}</title>


        <title>@yield('title','welcome to laravel')</title>
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" /> --}}

        <style>
            body {
                margin: 0;
                padding: 0;
                font: 12pt "Tahoma";
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
            .page {
                width: 21cm;
                min-height: 29.7cm;


                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }
            .subpage {
                padding: 0.2cm;
                height: 256mm;
            }
            @page {
                size: A4 portrait;
                margin: 0;
                /*size: landscape;*/
            }
            @media print {
                .page {
                    margin: 0;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                }
            }
            table {
                width: 100%;
                border: 1px solid #444444;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #444444;
            }
       </style>

    </head>
    <body>

        <div class="book">

            <div class="page">

                <div class="subpage">

                        <div style="text-align: center; border-top: 13px;">
                            <h1>강사비 지급 조서</h1>
                        </div>

                        <table class="" style="width: 100%; margin-bottom: 30px;">
                            <tr>
                                <td style="width:150px; padding: 10px;">성명</td>
                                <td colspan="2" style="padding-left: 10px;">{{$userInfo->name}}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; padding: 10px;">주민등록번호</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td style="width:150px; padding: 10px;">주소</td>
                                <td colspan="2" style="padding-left: 10px;">{{$userInfo->address}}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; padding: 10px;">연락처</td>
                                <td colspan="2" style="padding-left: 10px;">{{$userInfo->mobile}}</td>
                            </tr>
                            <tr>
                                <td style="width:150px; padding: 10px;">계좌번호</td>
                                <td style="width:150px; padding: 10px;"></td>
                                <td></td>
                            </tr>
                        </table>

                        <table class="" style="width: 100%; margin-bottom: 50px;">
                            <thead class="">
                                <tr style="align:center;">
                                    <th colspan="9">강의진행내용</th>
                                </tr>
                                <tr style="align:center;">
                                    <th width="120px;">강의주제</th>
                                    <th width="75px;">강의일</th>
                                    <th width="130px;">장소</th>
                                    <th width="30px;">시간</th>
                                    <th width="60px;">강사구분</th>
                                    <th width="70px;">지급총액</th>
                                    <th width="60px;">소득세</th>
                                    <th width="50px;">주민세</th>
                                    <th width="70px;">실지급액</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classList as $key => $list)
                                    @if(empty($list->contract_id))
                                        <tr>
                                            <td colspan="5" style="text-align:center; font-weight: bold;">총 계</td>
                                            <td style="text-align:right;">{{ number_format( $list->tot_cost ) }}&nbsp;</td>
                                            <td style="text-align:right;">{{ number_format( $list->i_tax ) }}&nbsp;</td>
                                            <td style="text-align:right;">{{ number_format( $list->r_tax ) }}&nbsp;</td>
                                            <td style="text-align:right;">{{ number_format( $list->calcu_cost ) }}&nbsp;</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $list->class_name}}</td>
                                            <td style="text-align:center;">{{ $list->class_day,'Y-m-d'}}</td>
                                            <td>{{ $list->client_name}}</td>
                                            <td style="text-align:center;">{{ $list->lector_main_count + $list->lector_extra_count}}</td>
                                            <td style="text-align:center;">{{ $list->main_yn == 0 ? '보조강사' : '주강사' }}</td>
                                            <td style="text-align:right;">{{ number_format( $list->tot_cost ) }}&nbsp; </td>
                                            <td style="text-align:right;">{{ number_format( $list->i_tax ) }}&nbsp;</td>
                                            <td style="text-align:right;">{{ number_format( $list->r_tax ) }}&nbsp;</td>
                                            <td style="text-align:right;">{{ number_format( $list->calcu_cost ) }}&nbsp;</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>


                        <table class="" style="width: 100%; margin-bottom: 30px; border:0px;">
                            <tr>
                                <td colspan="2" style="text-align:center; padding: 20px; border:unset"><font size="4">{{$thisYear}}년&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;월&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;일</font></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center; padding: 3px; border:unset">서초여성가족플라자는 프로그램 진행을 위해 최소한의 개인정보를 수집하며,</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center; padding: 3px; border:unset">이 개인정보는 서초여성가족플라자에 강사비 지급을 목적으로 제공되며, 타 기관에는</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center; padding: 3px; border:unset">제공되지 않습니다. 또한 정보주체는 이 동의를 언제든지 철회할 수 있습니다.</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; padding: 20px; border:unset; font-weight: bold;">개인정보 수집, 이용에 동의합니다. <input type="checkbox"></td>
                                <td style="width:300px; text-align:left; border:unset; font-weight: bold;">{{$userInfo->name}}&nbsp;&nbsp;&nbsp;(서명)</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center; padding: 30px; border:unset"><img src="{{ asset('/images/main_logo_top.png')}}" ></td>
                            </tr>
                        </table>

                </div>
            </div>
        </div>

    </body>
</html>


