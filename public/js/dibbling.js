$(function() {

    // web socket
    var socket = io(document.location.protocol+'//'+domain+'/socket');
    socket.on('playing',function (){
        console.log('change');
        refresh();
    });

    // playing
    function refreshPlaying() {
        let promise_get_playing = $.ajax({
            url: 'api/v2/playing',
            method: "GET"
        });

        promise_get_playing.done(function (data) {
            if (data.id) {
                // have playing
                $('#playing').text(data.title);
                $("#playing").attr("href", "https://www.youtube.com/watch?v=" + data.video_id);

            } else {
                // no playing
                $('#playing').text('Two Steps From Hell - Victory - YouTube');
                $("#playing").attr("href", "#");
            }
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
});
