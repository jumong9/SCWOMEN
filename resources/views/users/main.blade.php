@extends ('users.userlayout')

@section('title')
    사용자 메인 페이지
@endsection


@section('content')
    사용자 ID {{ $id}}
    사용자 이름 {{$user_name }}
@endsection
