@extends('layouts.layout_admin')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Member List</h1>

    <div>
        <ul>
            전체 {{$count}}건

            Eloquent
            @foreach($userlist as $key => $member)
                <li>
                    / {{ $loop->index }} /
                    {{ $member->id }} {{ $member->group }}
                    {{ $member->name }} {{ $member->email }}
                    {{ $member->grade }} {{ $member->status }} {{ $member->gubun }}
                    {{ $member->created_at }}
                    {{ $member->classCategories[0]->class_gubun}}
                    {{ $member->classCategories[0]->class_name}}
                    {{ $member->classCategories[0]->pivot->user_id}}
                    @foreach($member->classCategories as $member)
                        {{ $loop->index }} / {{ $member->class_gubun }} {{ $member->class_name }}
                    @endforeach
                </li>
            @endforeach

            RowQuery
            @foreach($ruserlist as $key => $member)
                <li>
                    / {{ $loop->index }} /
                    {{ $member->id }} {{ $member->group }}
                    {{ $member->name }} {{ $member->email }}
                    {{ $member->grade }} {{ $member->status }} {{ $member->gubun }}

                    {{ $member->class_gubun}}
                    {{ $member->class_name}}

                </li>
            @endforeach

            멤버내 카테고리 전체
            @foreach($userlist as $member)
                @foreach($member->classCategories as $category)
                <li>
                    {{ $category->class_gubun }} {{ $category->class_name }}
                </li>
                @endforeach
            @endforeach




            전체 카테고리
            @foreach($cate as $member)
                <li>
                    구분 {{ $member->class_gubun  }}  클래스 {{ $member->class_name }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection
