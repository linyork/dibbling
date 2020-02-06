$(function (){
    function refresh() {
        refreshPlaying();
    }
    refresh();
});

// dibbling
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
var socket = io('https://'+domain+':8443');
// cut
$(document).on('click', '#cut', function (e) {
    socket.emit('command', $(this).val()+'("99999",true)');
});
// voice
$(document).on('input', '#voice', function (e) {
    socket.emit('command', 'setVolume('+$(this).val()+')');
});
