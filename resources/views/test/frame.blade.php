<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','welcome to laravel')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />


    </head>
    <body>

        <!-- 상단 메뉴바 -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Left</a>
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
                        <a class="nav-link" href="#">Right</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- 상단 메뉴바 -->

        <!-- 하단 본문 -->
        <div class="container-fluid">
            <div class="row">

                <!-- 좌측 메뉴 -->
                <div class="col-md-2 d-flex flex-column bd-highlight mb-3 bg-secondary">
                    <div class="p-2 bd-highlight">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="#">HTML</a></li>
                            <li class="list-group-item active"><a href="#">CSS</a></li>
                            <li class="list-group-item"><a href="#">ECMAScript5</a></li>
                        </ul>
                    </div>
                    <div class="p-2 bd-highlight">Flex item 2</div>
                    <div class="p-2 bd-highlight">Flex item 3</div>
                </div>
                <!-- 좌측 메뉴 -->
                <!-- 9단길이의 첫번째 열 -->
                <div class="col-md-10">
                    <div class="">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>이름</th>
                                                <th>E-mail</th>
                                                <th>기수</th>
                                                <th>상태</th>
                                                <th>구분</th>
                                                <th>강사단</th>
                                                <th>과목</th>
                                                <th>등록일</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>qqqqq</td>
                                                <td>ccccc</td>
                                                <td>dddddd</td>
                                                <td>

                                                            승인대기중

                                                </td>
                                                <td>

                                                            내부

                                                </td>
                                                <td>khjk</td>
                                                <td>jkjkjk</td>
                                                <td>jkjkjkj</td>
                                            </tr> <tr>
                                                <td>qqqqq</td>
                                                <td>ccccc</td>
                                                <td>dddddd</td>
                                                <td>

                                                            승인대기중

                                                </td>
                                                <td>

                                                            내부

                                                </td>
                                                <td>khjk</td>
                                                <td>jkjkjk</td>
                                                <td>jkjkjkj</td>
                                            </tr> <tr>
                                                <td>qqqqq</td>
                                                <td>ccccc</td>
                                                <td>dddddd</td>
                                                <td>

                                                            승인대기중

                                                </td>
                                                <td>

                                                            내부

                                                </td>
                                                <td>khjk</td>
                                                <td>jkjkjk</td>
                                                <td>jkjkjkj</td>
                                            </tr> <tr>
                                                <td>qqqqq</td>
                                                <td>ccccc</td>
                                                <td>dddddd</td>
                                                <td>

                                                            승인대기중

                                                </td>
                                                <td>

                                                            내부

                                                </td>
                                                <td>khjk</td>
                                                <td>jkjkjk</td>
                                                <td>jkjkjkj</td>
                                            </tr> <tr>
                                                <td>qqqqq</td>
                                                <td>ccccc</td>
                                                <td>dddddd</td>
                                                <td>

                                                            승인대기중

                                                </td>
                                                <td>

                                                            내부

                                                </td>
                                                <td>khjk</td>
                                                <td>jkjkjk</td>
                                                <td>jkjkjkj</td>
                                            </tr> <tr>
                                                <td>qqqqq</td>
                                                <td>ccccc</td>
                                                <td>dddddd</td>
                                                <td>

                                                            승인대기중

                                                </td>
                                                <td>

                                                            내부

                                                </td>
                                                <td>khjk</td>
                                                <td>jkjkjk</td>
                                                <td>jkjkjkj</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 하단 본문 -->




    </body>
    <script src="{{ asset('sba/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
        });
    </script>
</html>
