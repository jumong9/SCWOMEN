<div class="row">
    <div class="col" id="list">
        <ul class="list-group list-group-flush">
            @each('memo.memo', $memo, 'memo', 'memo.nothing')
        </ul>
    </div>
</div>
