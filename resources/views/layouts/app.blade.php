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
    <script src="{{ asset('js/app.js').'?'.time() }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Dibbling Script & Css -->
    <link rel="stylesheet" href="{{ asset('css/common/bootstrap.css') }}">
    @guest
        <link rel="stylesheet" href="{{ asset('css/app_default.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/app_'.strtolower( Request::cookie('mode') ?? 'default' ).'.css') }}">
    @endguest
    <link rel="stylesheet" href="{{ asset('css/common/barrager.css') }}">

    <script src="{{ asset('js/common/jquery-3.4.1.js') }}"></script>
    <script src="{{ asset('js/common/jquery.barrager.min.js') }}"></script>
    <script src="{{ asset('js/socket.js') }}"></script>
    <script type="text/javascript">
        var web = @json(__('web'));
        var domain = "{{ config('app.domain') }}";
    </script>

    <!-- Page Css-->
    @yield('pageCss')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('admin')
                                        <a class="dropdown-item" href="{{ route('admin_interface') }}">{{ __('web.app.AdminInterface') }}</a>
                                    @endcan
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
        </main>
    </div>
    <!-- App Js -->
    <script src="/js/layout-app.js?{{ time() }}"></script>
    <!-- Page Js-->
    @yield('pageJs')
</body>
</html>
