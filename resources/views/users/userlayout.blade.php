<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','사용자 페이지')</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">

                <!--사이드바 내용-->
                <div class="span2">
                    <div>
                        <ul>
                            <li><a href="/">Welcome</a></li>
                            <li><a href="/hello">Hello</a></li>
                            <li><a href="/contact">Contact</a></li>
                        </ul>
                    </div>
                </div>

                <!--본문 내용-->
                <div class="span10">
                    @yield('content')
                </div>
            </div>
        </div>

    </body>
</html>
