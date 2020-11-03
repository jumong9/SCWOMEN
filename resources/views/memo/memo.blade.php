<li class="list-group-item">
    <small class="text-muted float-right">
        <a href="{{ route('memo.edit', ['memo' => $memo->getKey()]) }}">edit</a>
    </small>
    {{ $memo->memo }}
</li>
