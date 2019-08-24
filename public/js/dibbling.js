// var ws = new WebSocket('ws://local.dibbling.tw:9502');
//
// //開啟後執行的動作，指定一個 function 會在連結 WebSocket 後執行
// ws.onopen = () => {
//     console.log('WebSocket open connection');
//     ws.send("asdf");
// };
//
// //關閉後執行的動作，指定一個 function 會在連結中斷後執行
// ws.onclose = () => {
//     console.log('WebSocket close connection');
// };
//
// // onmessage  監聽
// ws.onmessage = (evt) => {
//     console.log(evt);
// };

// dibbling
$(document).on('click', '.btn-success', function(){
    dibbling($('#video-id').val());
    $("#video-id").val("");
});
$(document).on('click', '.btn-primary', function(){
    dibbling($(this).attr('data-id'));
});

//refresh
$(document).on('click', '.btn-info', function(){
    refreshPlaying();
    refreshList();
    refreshListPlayed();
});

// refresh playing & list & play list
$(function() {
    refreshPlaying();
    refreshList();
    refreshListPlayed();
});


function refreshPlaying(){
    let promise_get_playing = $.ajax({
        url: 'v1/playing',
        method: "GET"
    });

    promise_get_playing.done(function(data){
        if(data.id) {
            // have playing
            $('#playing').text(data.title);
        } else {
            // no playing
            $('#playing').text('Two Steps From Hell - Victory - YouTube');
        }
    });
}

function refreshList(){
    let list = $.ajax({
        url: '/v1/list',
        method: "GET"
    });

    list.done(function(db_list){
        let play_list_dom = $('#list');
        play_list_dom.empty();
        if (db_list.length <= 0) {
            // no video list
            play_list_dom.append("<li class='list-group-item'>無點播清單</li>");
        } else {
            // have video list and append video list
            db_list.forEach(function(element) {
                let title = element['title'];
                play_list_dom.append("<li class='list-group-item'>" +
                    title +
                    "</li>");
            });
        }
    });
}

function refreshListPlayed(){
    let promise_get_list = $.ajax({
        url: '/v1/list/played',
        method: "GET"
    });

    promise_get_list.done(function(db_list){
        let played_list_dom = $("#played-list");
        played_list_dom.empty();
        if (db_list.length <= 0) {
            // no video list
            played_list_dom.append("<li class='list-group-item'>無已播清單</li>");
        } else {
            // have video list and append video list
            db_list.forEach(function(element) {
                let video_id = element['video_id'];
                let title = element['title'];
                played_list_dom.append("<li class='list-group-item'>" +
                    "<a href='#' class='btn btn-primary' data-id='" + video_id + "'>" +
                    "再點播" +
                    "</a>" +
                    title +
                    "</li>");
            });
        }

    });
}

function dibbling(videoId) {
    let promise_post_list = $.ajax({
        url: 'v1/list',
        headers: {
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
    if(e['status'] === 1) {
        console.log('send');
        // ws.send("{id:"+e['videoId']+",title:"+e['title']+"}");
    }
    refreshList();
    refreshListPlayed();
    console.log(e);
}

function FailMethod(e) {
    alert(e);
    console.log(e);
}
