<html>
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/common/bootstrap.css') }}">
    <script src="{{ asset('js/common/jquery-3.4.1.js')}}"></script>
    <script src="{{ asset('js/common/bootstrap.js')}}"></script>
    <script async src="http://www.youtube.com/iframe_api"></script>
    <script src="{{ asset('js/player.js')}}"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-sm-12">
            <h1>廣播系統</h1>
            <span class="badge badge-primary">Interface</span>
            <span class="badge badge-secondary">v1.1</span>
            <div class="card">
                <div style="width: auto;"id="YouTubeVideoPlayer"></div>
                <div class="card-body">
                    <ul class="list-group" id="list">
                        <li class="list-group-item active">開機中</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
