<!DOCTYPE html>
@guest
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="{{ (Request::cookie('mode') === 'Dark') ? 'background-color: #333333 !important;' : '' }}">
@endguest
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- API Token -->
    @guest
    @else
        <meta name="api_token" content="{{ Auth::user()->api_token }}">
    @endguest

    <!-- APP Name -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('/js/app.js').'?'.time() }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Dibbling Script & Css -->
    <link rel="stylesheet" href="{{ asset('/css/common/bootstrap.css') }}">
    @guest
        <link rel="stylesheet" href="{{ asset('/css/app_default.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('/css/app_'.strtolower( Request::cookie('mode') ?? 'default' ).'.css') }}">
    @endguest
    <link rel="stylesheet" href="{{ asset('/css/common/barrager.css') }}">

    <script src="{{ asset('/js/common/jquery-3.4.1.js') }}"></script>
    <script src="{{ asset('/js/common/jquery.barrager.min.js') }}" defer></script>
    <script src="{{ asset('/js/socket.js') }}"></script>
    <script type="text/javascript">
        var web = @json(__('web'));
        var domain = "{{ config('app.domain') }}";
    </script>

    <!-- Page Css-->
    @yield('pageCss')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-{{ strtolower(Request::cookie('mode')) == 'dark' ? 'dark' : 'light' }} shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @guest
                        <img src="/logo_default.png" class="card-img-top">
                    @else
                        <img src="/logo_{{ strtolower( Request::cookie('mode') ?? 'default' ) }}.png" class="card-img-top">
                    @endguest
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('web.app.Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('web.app.Register') }}</a>
                                </li>
                            @endif
                            @include('common.localebutton')
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::currentRouteName() === 'dibbling') ? 'current-page' : '' }}" href="{{ route('dibbling') }}">
                                    {{ __('web.app.Dibbling') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::currentRouteName() === 'dibbling_list') ? 'current-page' : '' }}" href="{{ route('dibbling_list') }}">
                                    {{ __('web.app.List') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::currentRouteName() === 'dibbling_record') ? 'current-page' : '' }}" href="{{ route('dibbling_record') }}">
                                    {{ __('web.app.Record') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::currentRouteName() === 'dibbling_like') ? 'current-page' : '' }}" href="{{ route('dibbling_like') }}">
                                    {{ __('web.app.Like') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (Route::currentRouteName() === 'supporter') ? 'current-page' : '' }}" href="{{ route('supporter') }}">
                                    {{ __('web.app.Supporter') }}
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('admin')
                                        <a class="dropdown-item" href="{{ route('admin_interface') }}">{{ __('web.app.AdminInterface') }}</a>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('timeline') }}">{{ __('web.app.Timeline') }}</a>
                                    <a class="dropdown-item" href="{{ route('setting') }}">{{ __('web.app.Setting') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('web.app.Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            @include('common.go_to_top')
        </main>
    </div>

    <div class="modal" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="infoModalTitle"> {{ __('web.list.History') }}<br><span class="modal-sub-title"></span></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">{{ __('web.list.Close') }}</span></button>
            </div>
            <div class="modal-body">
            </div>

            <div class="modal-footer">
                <div>{{ __('web.list.Played') }}: <span class="info"></span></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('web.list.Close') }}</button>
            </div>

          </div>
        </div>
    </div>

    <!-- App Js -->
    <script src="{{ asset('/js/layout-app.js?'.time()) }}"></script>
    <!-- Page Js-->
    @yield('pageJs')
</body>
</html>
