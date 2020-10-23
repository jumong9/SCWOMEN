<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','welcome to laravel')</title>
        <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
    </head>
    <body>
        <div class="bg-red-900">Wow Tailwind</div>
        <ul>
            <li><a href="./main">Main Page</a></li>
            <li><a href="./hello">Hello Page</a></li>
            <li><a href="./bye">Bye Page</a></li>
        </ul>
        @yield('content')
    </body>
</html>
