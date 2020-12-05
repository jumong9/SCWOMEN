<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','welcome to laravel')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />


    </head>
    <body>

        <form name="searchForm" id="searchForm" action="/test/fileDo" method="post" enctype="multipart/form-data" >
            @csrf

            <input type="file" class="form-control-file" id="upload_file" name="upload_file">

            <button class="btn btn-primary" type="submit"  id="createButton">저장</button>
            <img src="{{ url( '/public\uploads\2020\acreport1kYNuw3deFzUyuzFgeihIGsStPDXiwTkLvB0Q4Hn.jpeg' )}}" width="300" height="200">

            <img src="{{ url( '/storage/excels/1kYNuw3deFzUyuzFgeihIGsStPDXiwTkLvB0Q4Hn.jpeg' )}}" width="300" height="200">
            <img src="{{ asset( '/storage/excels/1kYNuw3deFzUyuzFgeihIGsStPDXiwTkLvB0Q4Hn.jpeg' )}}" width="300" height="200">
        </form>

</html>
