<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','Laravel')</title>


    </head>
    <body>
            <div>
                @yield('content')
            </div>
            <div>
                <ul>
                    <li><a href="/">Welcome</a></li>
                    <li><a href="/hello">Hello</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>
    </body>
</html>
