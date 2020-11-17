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

        Eloquent
            @foreach($userlist as $key => $member)
                <li>
                    / {{ $loop->index }} /
                    {{ $member->id }} {{ $member->group }}
                    {{ $member->name }} {{ $member->email }}
                    {{ $member->grade }} {{ $member->status }} {{ $member->gubun }}
                    {{ $member->created_at }}
                    {{-- $member->classCategories[0]->class_gubun}}
                    {{ $member->classCategories[0]->class_name}}
                    {{ $member->classCategories[0]->pivot->user_id --}}
                    @foreach($member->classCategories as $member)
                        {{ $loop->index }} / {{ $member->class_gubun }} {{ $member->class_name }}
                    @endforeach
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
    </ul>
@endsection
