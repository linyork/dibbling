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
// log
socket.on('log', function(string){
    console.log(string);
});
// play
$(document).on('click', '#play', function (e) {
    socket.emit('command', $(this).val()+'()');
});
// cut
$(document).on('click', '#cut', function (e) {
    socket.emit('command', $(this).val()+'("99999",true)');
});
// pause
$(document).on('click', '#pause', function (e) {
    socket.emit('command', $(this).val()+'()');
});
// voice
$(document).on('input', '#voice', function (e) {
    socket.emit('command', 'setVolume('+$(this).val()+')');
});
