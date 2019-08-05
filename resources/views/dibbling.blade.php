<html>
    <head>
        <script src="{{ asset('js/common/jquery-3.4.1.js')}}"></script>
        <script>
            let ws = new WebSocket('ws://local.dibbling.tw:9502');

            //開啟後執行的動作，指定一個 function 會在連結 WebSocket 後執行
            ws.onopen = () => {
                console.log('open connection')
            };

            //關閉後執行的動作，指定一個 function 會在連結中斷後執行
            ws.onclose = () => {
                console.log('close connection')
            };

        </script>
    </head>
    <body>
    <div id="YouTubeVideoPlayer"></div>
    <script async src="http://www.youtube.com/iframe_api"></script>
    <script>
        function onYouTubeIframeAPIReady() {
            var player;
            player = new YT.Player('YouTubeVideoPlayer', {
                videoId: 'oEeLSBVsrJA',     // YouTube 影片ID
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
                    'onReady': function(e) {
                        console.log(e);
                        e.target.playVideo();
                    }
                }
            });
        }
    </script>
    </body>
</html>
