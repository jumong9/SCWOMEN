@extends ('test.layout')

@section('title')
    Project Page
@endsection


@section('content')
    Project Page

    <ul>
        @foreach($projects as $project)
            <li>Title : {{ $project->project_title }} Desc : {{ $project->desc }} Start Date :  {{ $project->created_at }}</li>
        @endforeach
    </ul>
@endsection