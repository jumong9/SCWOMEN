<div class="row">
    <div class="col pl-4 text-left">
        <small>
            <a href="{{ route('memo.index') }}">back</a>
        </small>
    </div>
    <div class="col pr-4 text-right">
        <form id="memo-delete" action="{{ route('memo.destroy', [
        	'memo' => $memo->id
        ]) }}" method="POST" class="d-none">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
        </form>
        <small>
            <a class="memo-delete text-danger" href="#">delete</a>
        </small>
    </div>
</div>
