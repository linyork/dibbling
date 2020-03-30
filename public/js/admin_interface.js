$(function () {

    // Delete
    $(document).on('click', '.delete', function () {
        let id = $(this).val();
        deleteUser(id);
    });

    // Broadcast
    $(document).on('click', '#broadcast-button', function () {
        broadcast($('#broadcast').val());
        $('#broadcastMP3').attr("src","broadcast.mp3?"+Date.now());
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
            console.log(result);
        });
    }
});
