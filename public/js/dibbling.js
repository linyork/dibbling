// web socket
let socket;
$.ajax({
    url: 'api/v2/user',
    headers: {
        'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
    },
    method: "GET"
}).done(function (data) {
    socket = io(document.location.protocol + '//' + domain + '/socket');
    
    /* 發送事件 */
    socket.emit('intoDibbling', data);
    
    /* 接收事件 */
    // playing
    socket.on('playing', function () {
        refresh();
    });
    // danmu
    socket.on('danmu', function (m) {
        showDanmu(m);
    });
    // chart
    socket.on('chat', function( chat ) {
        console.log(chat);
    });
    // sync data
    socket.on('setSync', function(value) {
        setSync(JSON.parse(value));
    });
    // next
    socket.on('next', function (title) {
        next(title);
    });

    /* 綁定事件 */
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
        //record
        $.ajax({
            url: 'api/v2/list/' + $(this).attr('data-id'),
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: "json",
            data: {
                'real': false
            }
        }).done(function (result) {
            var command = {
                command: 'cut',
                value: 'cut',
            };
            socket.emit('command', JSON.stringify(command));
        })
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
function refreshPlaying(update) {
    $.ajax({
        url: 'api/v2/playing',
        headers: {
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
        },
        method: "GET"
    }).done(function (data) {
        $("#video-interface").empty();
        $("#video-interface").append(data);
        socket.emit('getSync');
        if(update && $('#nextTitle').data('id')) {
            socket.emit('next', $('#nextTitle').val())
        }
    });
}

// dibbling
$(document).on('click', '#dibbling-button', function () {
    dibbling($('#video-id').val());
    $("#video-id").val("");
});
$(document).on('keydown', '#video-id', function (e) {
    if (e.which === 13){
        dibbling($('#video-id').val());
        $("#video-id").val("");
    }
});

$(document).on('click', '#danmu-button', function () {
    danmu($('#danmu-text').val());
    $("#danmu-text").val("");
});
$(document).on('keydown', '#danmu-text', function (e) {
    if (e.which === 13) {
        danmu($('#danmu-text').val());
        $("#danmu-text").val("");
    }
});


function refresh(update = false) {
    refreshPlaying(update);
}

function dibbling(videoId) {
    if (videoId === '') return;
    $.ajax({
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
    })
    .done(SuccessMethod)
    .fail(FailMethod);
}

function redibbling(id) {
    $.ajax({
        url: 'api/v2/list/' + id,
        headers: {
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "PUT",
        dataType: "json",
    });
}


function next(title) {
    if (title === '') return;
    $('#nextTitle').val(title)
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

function setSync(sync) {
    //sync volume
    setVolume(sync.volume)
    //sync speed
    setSpeed(sync.speed)
    //sync duration
    setDuration(sync.duration)
}

function setVolume(volume) {
    $('#voice').val(volume);
    $('#voiceRange').val(volume);
}

function setSpeed(speed) {
    $('#speed').val(speed);
    $('#speedRange').val(speed);
}

function setDuration(sec) {
    var duration = getDurationTime(sec)
    $('#duration').val(duration)
}

function getDurationTime(sec) {
    var min = Math.floor(sec / 60)
    var sec = (sec - min * 60)
    duration = min + ':' + (sec < 10 ? '0' : '') + sec + ' / '
    return duration
}

function SuccessMethod(e) {
    if (e.status === false && e.redibbling_id && confirm(e.msg)) {
        redibbling(e.redibbling_id);
    } else if (!e.redibbling_id) {
        alert(e.msg);
    }
    refresh(true);
}

function FailMethod(e) {
    alert(e.title + '\n\n' + e.msg);
    console.log(e);
}

refresh();
