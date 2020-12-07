<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel8') }}</title>


        <title>@yield('title','welcome to laravel')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    </head>
    <body>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{$pageTitle}}</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>활동일자</th>
                            <th>시간</th>
                            <th>수요처</th>
                            <th>프로그램</th>
                            <th>진행방식</th>
                            <th>교육대상</th>
                            <th>인원</th>
                            <th>작성자</th>
                            <th style="width: 200px;">교육내용</th>
                            <th style="width: 200px;">강사소견</th>
                            <th style="width: 200px;">사진자료</th>
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
                            <td>{{ $list->class_contents}}</td>
                            <td>{{ $list->class_rating}}</td>
                            <td>
                                <img src="{{ asset($list->file_path.'/'.$list->file_name)}}" width="200" height="170">
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="row-fluid" style="text-align: right;">
                <button class="btn btn-primary" type="button" name="printButton" id="printButton">선택출력</button>
            </div> --}}
        </div>
    </div>

</body>

<script src="{{ asset('js/app.js') }}"></script>
</html>
