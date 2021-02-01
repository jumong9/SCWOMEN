<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel8') }}</title>

        <title>@yield('title','welcome to laravel')</title>
        <style>

            body {
                margin: 1;
                padding: 0;
                font: 9pt "Tahoma";
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
            .page {
                width: 29.7cm;
                min-height: 21cm;


                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0);
            }
            .subpage {
                padding: 0.2cm;
                height: 256mm;
            }
            @media print {
              @page {
                size: 29.7cm 21cm; /*A4*/
                margin:1;
              }
              html, body { border:0; margin:0; padding:0; }
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

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <!-- DataTales Example -->
    <div class="book">

        <div class="page">
            <div class="subpage">
                <table class="" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 4cm;">활동일자</th>
                            <th style="width: 2cm;">시간</th>
                            <th style="width: 5cm;">수요처</th>
                            <th style="width: 5cm;">프로그램</th>
                            <th style="width: 5cm;">진행방식</th>
                            <th style="width: 5cm;">교육대상</th>
                            <th style="width: 2cm;">인원</th>
                            <th style="width: 3cm;">작성자</th>
                            <th style="width: 3cm;">보조강사</th>
                            <th style="width: 6cm;">교육내용</th>
                            <th style="width: 6cm;">강사소견</th>
                            <th style="width: 151x;">사진자료</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classList as $key => $list)
                        <tr>
                            <td>{{ $list->class_day,'Y-m-d'}}</td>
                            <td>{{ $list->time_from}} - {{ $list->time_to}}</td>
                            <td>{{ $list->client_name}}</td>
                            <td>{{ $list->class_name }} </td>
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
                            <td>{{ $list->sub_user_names}}</td>
                            <td>{{ $list->class_contents}}</td>
                            <td>{{ $list->class_rating}}</td>
                            <td>
                                <img src="{{ asset($list->file_path.'/'.$list->file_name)}}" width="150" height="150">
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>

</html>
