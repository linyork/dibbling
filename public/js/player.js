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
            syncDibbling();
            break;
        case 'speed':
            player_ref.setPlaybackRate(parseFloat(commandOptions.value));
            syncDibbling();
            break;
        case 'time':
            player_ref.seekTo(parseInt(commandOptions.value));
            syncDibbling();
            break;
    }
});
socket.on('broadcast', function (result){
    var originalVoice = player_ref.getVolume();
    player_ref.pauseVideo();
    player_ref.setVolume(100);
    $("#broadcast-div").empty();
    $("#broadcast-div").append("<audio id='broadcast-audio'><source src='"+result+"' type='audio/mpeg'></audio>");
    var audio = document.getElementById("broadcast-audio");
    audio.play();
    audio.addEventListener('ended', function(){
        player_ref.playVideo();
    }, false);
    player_ref.setVolume(originalVoice);
});
socket.on('getSync', function (){
    syncDibbling()
});

// init YT Player
function onYouTubeIframeAPIReady() {
    var player = new YT.Player('YouTubeVideoPlayer', {
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
    //調整YT時，同步至Dibbling
    var iframeWindow = player.getIframe() ? player.getIframe().contentWindow : '';
    window.addEventListener("message", function(event) {
        // Check that the event was sent from the YouTube IFrame.
        if (event.source === iframeWindow) {
            var data = JSON.parse(event.data);
            if (data.event === "infoDelivery" && data.info) {
                //sync data
                if(data.info.volume) syncDibbling();
                if(data.info.playbackRate) syncDibbling();
            }
        }
    });
    syncDibbling();
}

function syncDibbling() {
    if (!player_ref ||
        (init_volume == parseInt(player_ref.getVolume()) &&
        init_speed == player_ref.getPlaybackRate()) &&
        duration == parseInt(player_ref.getCurrentTime())) return
    //sync data
    init_volume = parseInt(player_ref.getVolume())
    init_speed = player_ref.getPlaybackRate()
    if (init_play && duration > 0) {
        player_ref.seekTo(duration, true)
        setTimeout(function() {
            init_play = false
        }, 500)
    } else {
        duration = parseInt(player_ref.getCurrentTime())
    }
    if (duration > duration_max) {
        player_ref.seekTo(99999, true);
    }
    //set data
    var sync_data = {
        volume: init_volume,
        speed: init_speed,
        duration: duration
    }
    socket.emit('setSync', JSON.stringify(sync_data))
}

// YT Player on ready
var player_ref;
var init_volume = 50;
var init_speed = 1;
var duration = 0;
var duration_max = 999;
var init_play = false;
function onPlayerReady(event) {
    player_ref = event.target;
    player_ref.setVolume(init_volume);
    player_ref.setPlaybackRate(init_speed);
    event.target.playVideo();
    syncDibbling();
}

// YT Player change state
function onPlayerStateChange(event) {
    if (event.data == 0) {
        playNext(event);
    }
}

// YT Player error
function onError(event){
    playNext(event);
}

function playNext(event) {
    $.ajax({
        url: '/api/v2/next',
        method: "GET"
    }).done(function (next) {
        if (next.id) {
            // append video list
            $("#list").empty();
            $("#list").append("<li class='list-group-item'>" + next.title + "</li>");
            // youtube
            event.target.loadVideoById(next.video_id);
            duration = parseInt(next.min);
            duration_max = parseInt(next.max);
            init_play = true;
        } else {
            // no video list
            $("#list").empty();
            $("#list").append("<li class='list-group-item'>No data</li>");
        }
        // socket
        socket.emit('playing')
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
