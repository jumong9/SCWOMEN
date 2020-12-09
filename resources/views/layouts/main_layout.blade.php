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
                    <li class="nav-item">
                        <a class="nav-link" href="">공지사항</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">서식자료함</a>
                    </li>

                @if (Auth::user()->grade >=90 )

                    <li class="nav-item pr-2">
                        <div class="dropdown show">
                            <a class="nav-link dropdown-toggle" href="{{ route('mgmt.member.list') }}" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                강사단 정보
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="{{ route('mgmt.member.list') }}">강사관리</a>
                              <a class="dropdown-item" href="{{ route('mgmt.application.list') }}?searchStatus=0">강사승인관리</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item pr-2">
                        <div class="dropdown show">
                            <a class="nav-link dropdown-toggle" href="{{ route('mgmt.client.list') }}" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                수요처 정보
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="{{ route('mgmt.client.list') }}">수요처관리</a>
                              <a class="dropdown-item" href="{{ route('mgmt.contract.list') }}">계약관리</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item pr-2">
                        <div class="dropdown show">
                            <a class="nav-link dropdown-toggle" href="{{ route('mgmt.lecture.list') }}" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                강사배정 정보
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('mgmt.lecture.list') }}">강사배정관리</a>
                                <a class="dropdown-item" href="{{ route('mgmt.acreport.list') }}">활동일지관리</a>
                            </div>
                        </div>
                    </li>

                @elseif (Auth::user()->grade >=10 )

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('grade.lecture.list') }}">강사배정관리</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('grade.mylecture.list') }}">나의강좌관리</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('grade.acreport.list') }}">활동일지관리</a>
                    </li>

                @else

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('grade.mylecture.list') }}">나의강좌관리</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('grade.acreport.list') }}">활동일지관리</a>
                    </li>

                @endif
                </ul>
            </div>
            <div class="mx-auto order-0">
                <a class="navbar-brand mx-auto" href="#">{{ config('app.name', 'Laravel8') }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 159px;">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if (Auth::user()->grade < 90 )
                                    <a class="dropdown-item" href="{{ route('auth.myinfo.update') }}">개인정보</a>
                                @endif
                                    <a class="dropdown-item" href="{{ route('auth.myinfo.passwd') }}">비밀번호변경</a>

                                    <a class="dropdown-item" href="{{ route('auth.logoutdo') }}">로그아웃</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- 상단 메뉴바 -->

        <!-- 하단 본문 -->
        <div class="container-fluid">
            <div class="row">

                <!-- 9단길이의 첫번째 열 -->
                <div class="col-md-12 pt-3">

                    @yield('content')

                </div>
            </div>
        </div>
        <!-- 하단 본문 -->




    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.datepicker').datepicker(
                {
                    dateFormat: 'yy-mm-dd',	//날짜 포맷이다. 보통 yy-mm-dd 를 많이 사용하는것 같다.
                    changeMonth : true,
                    changeYear : true,
                    yearRange: 'c-100:c+10',
                    prevText: '이전 달',	// 마우스 오버시 이전달 텍스트
                    nextText: '다음 달',	// 마우스 오버시 다음달 텍스트
                    closeText: '닫기', // 닫기 버튼 텍스트 변경
                    currentText: '오늘', // 오늘 텍스트 변경
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],	//한글 캘린더중 월 표시를 위한 부분
                    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],	//한글 캘린더 중 월 표시를 위한 부분
                    dayNames: ['일', '월', '화', '수', '목', '금', '토'],	//한글 캘린더 요일 표시 부분
                    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],	//한글 요일 표시 부분
                    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],	// 한글 요일 표시 부분
                    showMonthAfterYear: true,	// true : 년 월  false : 월 년 순으로 보여줌
                    yearSuffix: '',	//
            //        showButtonPanel: true,	// 오늘로 가는 버튼과 달력 닫기 버튼 보기 옵션
            //        buttonImageOnly: true,	// input 옆에 조그만한 아이콘으로 캘린더 선택가능하게 하기
            //        buttonImage: "images/calendar.gif",	// 조그만한 아이콘 이미지
            //        buttonText: "Select date"	// 조그만한 아이콘 툴팁
                }
            );

        });
    </script>

    @yield('scripts');

</html>
