<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/common/bootstrap.css">
    <script src="js/common/jquery-3.4.1.js"></script>
    <script src="js/common/bootstrap.js"></script>
    <script async src="//www.youtube.com/iframe_api"></script>
    <script src="js/socket.js"></script>
    <script type="text/javascript">
        var domain = "{{ config('app.domain') }}";
    </script>
    <script src="js/player.js?{{ time() }}"></script>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-sm-12">
            <h1>廣播系統</h1>
            <div id="broadcast-div">
            </div>
            <span class="badge badge-primary">Interface</span>
            <span class="badge badge-secondary">v2.0</span>
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
</body>
</html>
