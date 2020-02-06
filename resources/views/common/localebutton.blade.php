<div class="btn-group">
    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('web.Language') }}
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('set_locale','en') }}">English</a>
        {{--                                        <a class="dropdown-item" href="{{ route('set_locale','jp') }}">jp</a>--}}
        <a class="dropdown-item" href="{{ route('set_locale','tw') }}">中文</a>
    </div>
</div>
