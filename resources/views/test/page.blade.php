<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','welcome to laravel')</title>
        <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
        <style>
            .frame{
                width: 100%;
                height: 100%;
                margin: 0 auto;
                border: 1px solid #aaa;
            }

            .header{
                padding:40px 10px;
                text-align: center;
                background: #eee;
                margin-bottom: 20px;
            }

            .container {
                overflow: hidden;
            }

            .nav {
                float: left;
                width: 150px;
                background: #333;
                color: #fff;
                margin-right: 50px;
            }
            .nav-list {
                list-style: none;
                margin: 0;
                padding: 10px 0;
            }
            .nav-item {
                margin: 4px 0;
            }
            .nav-link {
                display: block;
                text-decoration: none;
                padding: 4px 10px;
                color: #fff;
            }
            .nav-link:hover {
                background: #5457de;
            }

            .content {
                float: left;
                width: 600px;
            }

            .footer {
                text-align: center;
                border-top: 1px solid #aaa;
                margin: 20px 20px 0;
                font-size: 12px;
            }

        </style>
    </head>
    <body>
        <div class="frame">
            <div class="header">top mene area</div>

            <div class="container">

                <div class="nav">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="" class="nav-link">Menu-1</a></li>
                        <li class="nav-item"><a href="" class="nav-link">Menu-2</a></li>
                        <li class="nav-item"><a href="" class="nav-link">Menu-3</a></li>
                    </ul>
                </div>

                <div class="content">
                    <div class="bg-red-700">Wow Tailwind</div>
                    <ul>
                        <li><a href="./main">Main Page</a></li>
                        <li><a href="./hello">Hello Page</a></li>
                        <li><a href="./bye">Bye Page</a></li>
                    </ul>
                    @yield('content')
                    <pre>
                        dlsflsjfldsjfd
                        dfdfdfdfdasdfas
                        asdfsadfsadfdsafadsfsadf

                        sdfsadfdsafsadfdsafsadfsad


                        sadfsdfdsafdsafdsafdsa
                        dsafsadfsadfsadf
                    </pre>
                </div>
            </div>

            <div class="footer">
                <p class="copyright">&copy;copyright</p>
            </div>
        </div>
    </body>
</html>
