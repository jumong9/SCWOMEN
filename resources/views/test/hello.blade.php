@extends ('test.layout')

@section('title')
    Hello
@endsection


@section('content')
    Hello there {{ $id}} {{$password }}
@endsection
