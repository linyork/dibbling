function  getCookie(name) {
    var cookieName=encodeURIComponent(name)+'=';
    var cookieStart = document.cookie.indexOf(cookieName);

    if (cookieStart>-1) {
        var cookieEnd=document.cookie.indexOf(';',cookieStart);
        if(cookieEnd==-1){
            cookieEnd=documet.cookie.length;
        }
        cookieValue=decodeURIComponent(document.cookie.substring(cookieStart+cookieName.length,cookieEnd));
        return   cookieValue;
    }
}

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
function __(string) {
    return eval(string);
}
