<div class="btn-group">
    <button type="button" class="btn btn-{{ strtolower(Request::cookie('mode') == 'dark') ?: 'secondary' }} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('web.Language') }}
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('set_locale','en') }}">English</a>
        <a class="dropdown-item" href="{{ route('set_locale','jp') }}">日本語</a>
        <a class="dropdown-item" href="{{ route('set_locale','tw') }}">繁體中文</a>
    </div>
</div>
