// web socket
var socket = io(document.location.protocol+'//'+domain+'/socket/player');
socket.on('connect', function(){});
socket.on('disconnect', function(){});
socket.on('command', function(command){
    console.log(command);
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

// init YT Player
function onYouTubeIframeAPIReady() {
    new YT.Player('YouTubeVideoPlayer', {
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
}

// YT Player error
function onError(event){
    playNext(event);
}

function playNext(event) {
    var list = $.ajax({
        url: '/api/v2/list',
        method: "GET"
    });

    list.done(function (dblist) {
        if (dblist.length > 0) {
            // append video list
            var onplay_id = dblist[0]['id'];
            $("#list").empty();
            for (const [key, row] of Object.entries(dblist)) {
                var id = row['id'];
                var video_id = row['video_id'];
                var title = row['title'];
                $("#list").append("<li class='list-group-item' id='" + id + "' video_id='" + video_id + "'>" + title + "</li>");
            }

            // get onplay video & tag onplay video
            var onplay_video = dblist[0];
            event.target.loadVideoById(onplay_video['video_id']);
            videoData = event.target.getVideoData();
            $('#' + onplay_id).addClass('active');

            // delete first video
            remove(onplay_video['id']);

            // ajax add playing
            playing(onplay_video['id'])
        } else {
            // no video list
            $("#list").empty();
            $("#list").append("<li class='list-group-item'>No data</li>");
            playRandom(event);
        }
    });
}

function remove(id) {
    $.ajax({
        url: 'api/v2/list/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        dataType: "json",
    });
}

function playing(id) {
    var promise_post_playing = $.ajax({
        url: 'api/v2/playing',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        dataType: "json",
        data: {
            'id': id,
        },
    });
    promise_post_playing.done(function (){
        // socket
        socket.emit('playing')
    });
}

function playRandom(event){
    var promise_get_random = $.ajax({
        url: '/api/v2/list/random',
        method: "GET"
    });
    promise_get_random.done(function (data) {
        if (data.id) {
            // play this video
            event.target.loadVideoById(data.video_id);
            // ajax add playing
            playing(data.id)
        } else {
            // todo
            event.target.loadVideoById('hKRUPYrAQoE');
        }
    });

    promise_get_random.fail(function (d) {
        // todo
        event.target.loadVideoById('hKRUPYrAQoE');
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
