<div class="btn-group">
    <button type="button" class="btn btn-{{ strtolower(Request::cookie('mode') == 'dark') ?: 'secondary' }} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __((Request::cookie('mode') )? 'web.setting.'.Request::cookie('mode') : 'web.setting.Default') }}
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('set_mode','Default') }}">{{ __('web.setting.Default') }}</a>
        <a class="dropdown-item" href="{{ route('set_mode','Dark') }}">{{ __('web.setting.Dark') }}</a>
    </div>
</div>
