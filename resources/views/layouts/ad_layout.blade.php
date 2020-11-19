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

        <!-- 상단 메뉴바 -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('member.list') }}">강사관리</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="//codeply.com">Codeply</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                </ul>
            </div>
            <div class="mx-auto order-0">
                <a class="navbar-brand mx-auto" href="#">Navbar 2</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ Auth::user()->name }} {{ Auth::user()->grade }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.logoutdo') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- 상단 메뉴바 -->

        <!-- 하단 본문 -->
        <div class="container-fluid">
            <div class="row">

                <!-- 9단길이의 첫번째 열 -->
                <div class="col-md-12">

                    @yield('content')

                </div>
            </div>
        </div>
        <!-- 하단 본문 -->




    </body>
    <script src="{{ asset('sba/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //alert('admin layer');
        });
    </script>

    @yield('scripts');

</html>
