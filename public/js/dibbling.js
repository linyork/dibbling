// web socket
var socket;
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
    $.ajax({
        url: 'api/v2/playing',
        headers: {
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
        },
        method: "GET"
    }).done(function (data) {
        $("#video-interface").empty();
        $("#video-interface").append(data);
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


function refresh() {
    refreshPlaying();
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
    if (e.status === false && e.redibbling_id && confirm(e.msg)) {
        redibbling(e.redibbling_id);
    } else if (!e.redibbling_id) {
        alert(e.msg);
    }
    refresh();
}

function FailMethod(e) {
    alert(e.title + '\n\n' + e.msg);
    console.log(e);
}

refresh();
