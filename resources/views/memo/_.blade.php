<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')Memo</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('app.css') }}">

</head>
<body>
    <div id="mmmo" class="app container">
        @yield('form')
        @yield('list')
    </div>
    <script src="{{ asset('app.js') }}"></script>
</body>
</html>
