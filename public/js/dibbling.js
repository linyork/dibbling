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
