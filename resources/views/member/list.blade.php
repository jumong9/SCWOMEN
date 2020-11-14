@extends('layouts.layout_admin')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Member List</h1>

    <div>
        <ul>
            @foreach($userlist as $member)
                <li>
                    {{ $member->id }} {{ $member->name }} {{ $member->email }} {{ $member->grade }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection
