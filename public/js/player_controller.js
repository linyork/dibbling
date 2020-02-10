
// sse
// $(document).on('click', '.command', function (e) {
//     var command = $(this).val();
//     $.ajax({
//         url: 'api/v2/command/',
//         headers: {
//             'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type: "POST",
//         dataType: "json",
//         data: {
//             'command': command,
//         },
//     });
// });

// web socket
var socket = io(document.location.protocol+'//'+domain+'/socket');
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

