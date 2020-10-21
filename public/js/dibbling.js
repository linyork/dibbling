// web socket
var socket;
let promise_get_playing = $.ajax({
    url: 'api/v2/user',
    headers: {
        'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
    },
    method: "GET"
});

promise_get_playing.done(function (data) {
    socket = io(document.location.protocol + '//' + domain + '/socket');
    socket.emit('intoDibbling', data);
    socket.on('playing', function () {
        refresh();
    });

    socket.on('danmu', function (m) {
        showDanmu(m);
    });

    // chart
    socket.on('chat', function( chat ) {
        console.log(chat);
    });
    // play
    $(document).on('click', '#play', function (e) {
        var command = {
            command: 'play',
            value: 'play',
        };
        socket.emit('command', JSON.stringify(command));
    });
    // cut
    $(document).on('click', '#cut', function (e) {
        var command = {
            command: 'cut',
            value: 'cut',
        };
        socket.emit('command', JSON.stringify(command));
    });
    // pause
    $(document).on('click', '#pause', function (e) {
        var command = {
            command: 'pause',
            value: 'pause',
        };
        socket.emit('command', JSON.stringify(command));
    });
    // voice
    $(document).on('input', '#voice', function (e) {
        var command = {
            command: 'voice',
            value: $(this).val()
        };
        socket.emit('command', JSON.stringify(command));
    });
    // speed
    $(document).on('input', '#speed', function (e) {
        var command = {
            command: 'speed',
            value: $(this).val()
        };
        socket.emit('command', JSON.stringify(command));
        $("#show-speed").text($(this).val());
    });
});

$(document).on('click', '#like', function (e) {
    var button = $(this);
    var like = $.ajax({
        url: 'api/v2/like',
        headers: {
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        dataType: "json",
        data: {
            'videoId': $(this).attr('data-id'),
        },
    });
    like.done(function (result) {
        if(result['like']) {
            button.find('span').text(parseInt(button.find('span').text())+1);
            button.find('i').removeClass('fas');
            button.find('i').removeClass('far');
            button.find('i').addClass('fas');
        } else {
            button.find('span').text(parseInt(button.find('span').text())-1);
            button.find('i').removeClass('fas');
            button.find('i').removeClass('far');
            button.find('i').addClass('far');
        }
    });
});

// playing
function refreshPlaying() {
    let promise_get_playing = $.ajax({
        url: 'api/v2/playing',
        headers: {
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
        },
        method: "GET"
    });

    promise_get_playing.done(function (data) {
        $("#video-interface").empty();
        $("#video-interface").append(data);
    });

}

// dibbling
$('#video-id').keydown(function (e) {
    if (e.keyCode == 13) {
        dibbling($('#video-id').val());
        $("#video-id").val("");
    }
});

$(document).on('click', '#dibbling-button', function () {
    dibbling($('#video-id').val());
    $("#video-id").val("");
});

$(document).on('click', '#danmu-button', function () {
    danmu($('#danmu-text').val());
    $("#danmu-text").val("");
});

function refresh() {
    refreshPlaying();
}

function dibbling(videoId) {
    if (videoId === '') return;
    let promise_post_list = $.ajax({
        url: 'api/v2/list',
        headers: {
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        dataType: "json",
        data: {
            'videoId': videoId,
        },
    });
    promise_post_list.done(SuccessMethod);
    promise_post_list.fail(FailMethod);
}

function danmu(m) {
    if (m === '') return;
    socket.emit('danmu', m);
}

function showDanmu(m) {
    $('body').barrager({
        info: m,
        close: true,
        speed: 30,
        color: '#fff',
        old_ie_color: '# 000000',
    });
}

function SuccessMethod(e) {
    if (e['status'] === false) {
        alert(e.msg);
    }
    refresh();
}

function FailMethod(e) {
    alert(e);
    console.log(e);
}

refresh();
