@if (session()->has('status'))
    <div class="alert alert-info alert-dismissible status-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <span><i class="icon fas fa-info"></i> {{ session()->get('status') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible status-error" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @if ($errors->count() > 1)
            <span><i class="icon fas fa-exclamation-triangle"></i> エラーがあります。</span>
        @else
            <span><i class="icon fas fa-exclamation-triangle"></i> {{ $errors->first() }}</span>
        @endif
    </div>
@endif
