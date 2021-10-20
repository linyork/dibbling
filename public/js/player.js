// web socket
var socket = io(document.location.protocol+'//'+domain+'/socket/player');
socket.on('connect', function(){});
socket.on('disconnect', function(){});
socket.on('command', function(command){
    var commandOptions = JSON.parse(command);
    switch(commandOptions.command)
    {
        case 'play':
            player_ref.playVideo();
            break;
        case 'cut':
            player_ref.seekTo("99999",true);
            break;
        case 'pause':
            player_ref.pauseVideo();
            break;
        case 'voice':
            player_ref.setVolume(parseInt(commandOptions.value));
            break;
        case 'speed':
            player_ref.setPlaybackRate(parseFloat(commandOptions.value));
            break;
    }
});
socket.on('broadcast', function (result){
    player_ref.pauseVideo();
    $("#broadcast-div").empty();
    $("#broadcast-div").append("<audio id='broadcast-audio'><source src='"+result+"' type='audio/mpeg'></audio>");
    var audio = document.getElementById("broadcast-audio");
    audio.play();
    audio.addEventListener('ended', function(){
        player_ref.playVideo();
    }, false);
});

// init YT Player
function onYouTubeIframeAPIReady() {
    new YT.Player('YouTubeVideoPlayer', {
        videoId: 'TYMxVGn-xi4',     // YouTube 影片ID
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
            'onStateChange': onPlayerStateChange,
            'onError': onError,
        }
    });
}

// YT Player on readey
var player_ref;
function onPlayerReady(event) {
    player_ref = event.target;
    event.target.playVideo();
}

// YT Player change state
function onPlayerStateChange(event) {
    if (event.data == 0) {
        playNext(event);
    }
    // socket
    socket.emit('playing')
}

// YT Player error
function onError(event){
    playNext(event);
}

function playNext(event) {
    var list = $.ajax({
        url: '/api/v2/next',
        method: "GET"
    });

    list.done(function (next) {
        if (next.id) {
            // append video list
            $("#list").empty();
            $("#list").append("<li class='list-group-item'>" + next.title + "</li>");
            // youtube
            event.target.loadVideoById(next.video_id);
        } else {
            // no video list
            $("#list").empty();
            $("#list").append("<li class='list-group-item'>No data</li>");
        }
    });
}

// // sse
// function sseServer() {
//     var sse = new EventSource('sse_server.php');
//     sse.addEventListener('open', open, false);
//     sse.addEventListener('message', message, false);
//     sse.addEventListener('error', error, false);
// }
//
// function open(event) {
//     console.log('與 Server 正常連接！');
// }
//
// function message(event) {
//     var command_list = JSON.parse(event.data);
//     if(command_list.constructor === Object && command_list.status === true) {
//         command_list.data.forEach(function(this_command){
//             switch (this_command.command) {
//                 case 'seekTo':
//                     player_ref.seekTo(2000, true);
//                     break;
//             }
//         });
//     }
// }
//
// function error(event) {
//     closeEventSource();
//     console.log(event);
// }
//
// function closeEventSource() {
//     sse.close();
// }
