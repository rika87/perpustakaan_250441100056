@if (session('status'))
    <div class="bk-alert bk-success" role="alert">{{ session('status') }}</div>
@endif

@if (session('galat'))
    <div class="bk-alert bk-danger" role="alert">{{ session('galat') }}</div>
@endif

@if ($errors->any())
    <div class="bk-alert bk-warning" role="alert">{{ $errors->first() }}</div>
@endif