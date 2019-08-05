<html>
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/common/bootstrap.css') }}">
    <script src="{{ asset('js/common/jquery-3.4.1.js')}}"></script>
    <script src="{{ asset('js/common/bootstrap.js')}}"></script>
    <script async src="http://www.youtube.com/iframe_api"></script>
    <script>
        let ws = new WebSocket('ws://local.dibbling.tw:9502');

        //開啟後執行的動作，指定一個 function 會在連結 WebSocket 後執行
        ws.onopen = () => {
            console.log('WebSocket open connection')
        };

        //關閉後執行的動作，指定一個 function 會在連結中斷後執行
        ws.onclose = () => {
            console.log('WebSocket close connection')
        };

    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 .col-md-12 .col-sm-12">
            <div class="card" style="width: 560px;">
                <div id="YouTubeVideoPlayer"></div>
                <div class="card-body">
                    <ul class="list-group" id="list">
                        <li class="list-group-item active">Cras justo odio</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function onYouTubeIframeAPIReady() {
        var player;
        player = new YT.Player('YouTubeVideoPlayer', {
            videoId: 'H4vrIS2gc4k',     // YouTube 影片ID
            width: 560,                 // 播放器寬度 (px)
            height: 316,                // 播放器高度 (px)
            playerVars: {
                autoplay: 1,            // 在讀取時自動播放影片
                controls: 1,            // 在播放器顯示暫停／播放按鈕
                showinfo: 0,            // 隱藏影片標題
                modestbranding: 1,      // 隱藏YouTube Logo
                loop: 0,                // 讓影片循環播放
                fs: 0,                  // 隱藏全螢幕按鈕
                cc_load_policty: 0,     // 隱藏字幕
                iv_load_policy: 3,      // 隱藏影片註解
                autohide: 0             // 當播放影片時隱藏影片控制列
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        player_ref = event.target;
        event.target.playVideo();
    }

    function onPlayerStateChange(event) {
        if (event.data === 0) {

            var promise = $.ajax({
                url: '/player/list',
                method: "GET"
            });

            promise.done(function(dblist){
                var video = dblist[0];
                event.target.loadVideoById(video['video_id']);
                // TODO: api delete first video
            });

        }
    }
    $( document ).ready(function() {

        var promise = $.ajax({
            url: '/player/list',
            method: "GET"
        });

        promise.done(function(dblist){
            for (const [key, row] of Object.entries(dblist)) {
                $("#list").append("<li class='list-group-item' id='"+row['video_id']+"'>"+row['video_id']+"</li>");
            }
        });

    });
</script>
</body>
</html>
