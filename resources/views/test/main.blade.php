@extends ('test.layout')

@section('title')
    MainPage
@endsection


@section('content')
    Welcome to my Laravel World.
    <ul>
        @foreach($books as $book)
            <li>{{ $book }}</li>
        @endforeach
    </ul>
@endsection
