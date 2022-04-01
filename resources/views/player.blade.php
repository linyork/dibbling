<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/css/common/bootstrap.css') }}">
    <script src="{{ asset('/js/common/jquery-3.4.1.js') }}"></script>
    <script src="{{ asset('/js/common/bootstrap.js') }}"></script>
    <script async src="//www.youtube.com/iframe_api"></script>
    <script type="text/javascript">
        var domain = "{{ config('app.domain') }}";
        var channel = "{{ Request::cookie('channel') ?? 'tw' }}";
    </script>
    <script src="{{ asset('/js/socket.js') }}"></script>
    <title>Dibbling Player</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-sm-12">
            <h1>廣播系統</h1>
            <div id="broadcast-div">
            </div>
            <span class="badge badge-primary">Interface</span>
            <span class="badge badge-secondary">v2.1</span>

            <ul class="nav nav-pills nav-justified {{Request::cookie('channel')}}">
                <?php $cookie = Request::cookie('channel') ?? 'tw'?>
                <li class="nav-item">
                    <a class="nav-link {{ ($cookie === 'jp') ? 'active' : '' }}" href="{{ route('set_channel', ['channel' => 'jp']) }}">{{ __('web.channel.JP') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($cookie === 'tw') ? 'active' : '' }}" href="{{ route('set_channel', ['channel' => 'tw']) }}">{{ __('web.channel.TW') }}</a>
                </li>
            </ul>
            <div class="card">
                <div style="width: auto;" id="YouTubeVideoPlayer"></div>
                <div class="card-body">
                    <ul class="list-group" id="list">
                        <li class="list-group-item active">開機中</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/player.js?').time() }}"></script>
</body>
</html>
