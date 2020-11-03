@php
$isEdit = Route::currentRouteName() == 'memo.edit';
@endphp

<div class="row">
    <div class="col p-4" id="form">
        {!! Form::open([
        	'route' => $isEdit ?
            	['memo.update', 'memo' => $memo->getKey()] :
                'memo.store'
        ]) !!}
        @if ($isEdit)
        {{ method_field('PUT') }}
        @endif
        <div class="form-group">
            {!! Form::textarea('memo', ($isEdit ? $memo->memo : null), [
                'class' => 'form-control',
                'placeholder' => '퀵메모 헛소리없음',
                'rows' => 6,
            ]) !!}
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block" disabled="disabled">
        	MEMO
        </button>
        {!! Form::close() !!}
    </div>
</div>
