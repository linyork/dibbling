$(function () {
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
    });

    // Delete
    $(document).on('click', '.delete', function () {
        let name = $("#user-" + this.value + " td:first-child").text()
        if (confirm('你確定要把' + name + '刪掉嗎')) {
            deleteUser(this.value);
        } else {
            alert('還好我有做提醒功能了!');
        }
    });

    // Broadcast
    $(document).on('click', '#broadcast-button', function () {
        broadcast($('#broadcast').val());
    });

    function deleteUser(id) {
        let deleteUser = $.ajax({
            url: 'api/v2/user/delete/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE"
        });

        deleteUser.done(function (result) {
            if(result !== '0'){
                $("#user-"+id).remove();
            }
        });
    }

    function broadcast (str) {
        let broadcast = $.ajax({
            url: 'api/v2/broadcast',
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            data: {
                'text': str,
            }
        });

        broadcast.done(function (result) {
            socket.emit('broadcast', result);
        });
    }
});
