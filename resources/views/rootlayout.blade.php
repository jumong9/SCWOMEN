<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','Laravel')</title>


    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">

                <!--사이드바 내용-->
                <div class="span2">
                </div>

                <!--본문 내용-->
                <div class="span10">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
