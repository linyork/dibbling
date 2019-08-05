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
        <div class="col-sm-12 col-md-12 col-sm-12">
            <h1>廣播系統</h1>
            <span class="badge badge-primary">Interface</span>
            <span class="badge badge-secondary">v1.0</span>
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


<script>
    function onYouTubeIframeAPIReady() {
        var player;
        player = new YT.Player('YouTubeVideoPlayer', {
            videoId: 'H4vrIS2gc4k',     // YouTube 影片ID
            // width: 560,                 // 播放器寬度 (px)
            // height: 316,                // 播放器高度 (px)
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
            $("#list").empty();

            var promise_get_list = $.ajax({
                url: '/player/list',
                method: "GET"
            });

            promise_get_list.done(function(dblist){
                // append video list
                var onplay_id = dblist[0]['id'];
                for (const [key, row] of Object.entries(dblist)) {
                    var id = row['id'];
                    var voideo_id = row['video_id'];
                    var title = row['title'];
                    $("#list").append("<li class='list-group-item' id='"+id+"' voideo_id='"+voideo_id+"'>"+title+"</li>");
                }

                // get onplay video
                var onplay_video = dblist[0];
                event.target.loadVideoById(onplay_video['video_id']);
                videoData = event.target.getVideoData();

                // tag onplay
                $('#'+onplay_id).addClass('active');

                // delete first video
                $.ajax({
                    url: '/player/delete/'+onplay_video['id'],
                    method: "GET"
                });
            });
        }
    }
</script>
</body>
</html>
