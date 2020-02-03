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
