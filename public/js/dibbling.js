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
$(document).on('click', '.btn-success', function(event){
    var vidoId = $("#video-id").val();
    dibbling(vidoId);
    $("#video-id").val("");
});
$(document).on('click', '.btn-primary', function(event){
    var vidoId = $(this).attr('video_id');
    dibbling(vidoId);
});

//refresh
$(document).on('click', '.btn-info', function(event){
    refreshPlaying();
    refreshList();
    refreshPlayedList();
});

// refresh playing & list & play list
refreshPlaying();
refreshList();
refreshPlayedList();

function refreshPlaying(){
    var promise_get_playing = $.ajax({
        url: 'v1/playing',
        method: "GET"
    });

    promise_get_playing.done(function(data){
        console.log(data);
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

    $("#list").empty();
    var promise_get_list = $.ajax({
        url: '/player/list',
        method: "GET"
    });

    promise_get_list.done(function(dblist){
        if(dblist.length > 0) {
            // append video list
            $("#list").empty();
            for (const [key, row] of Object.entries(dblist)) {
                var id = row['id'];
                var video_id = row['video_id'];
                var title = row['title'];
                $("#list").append("<li class='list-group-item' id='"+id+"' video_id='"+video_id+"'>"+ title+"</li>");
            }
        } else {
            // no video list
            $("#list").empty();
            $("#list").append("<li class='list-group-item'>無點播清單</li>");
        }

    });
}

function refreshPlayedList(){
    $("#played-list").empty();
    var promise_get_list = $.ajax({
        url: '/player/played-list',
        method: "GET"
    });

    promise_get_list.done(function(dblist){
        if(dblist.length > 0) {
            // append video list
            $("#played-list").empty();
            for (const [key, row] of Object.entries(dblist)) {
                var id = row['id'];
                var video_id = row['video_id'];
                var title = row['title'];
                $("#played-list").append("<li class='list-group-item' id='"+id+"' video_id='"+video_id+"'><a href='#' class='btn btn-primary' video_id='"+video_id+"'>再點播</a>"+title+"</li>");
            }
        } else {
            // no video list
            $("#played-list").empty();
            $("#played-list").append("<li class='list-group-item'>無已播清單</li>");
        }

    });
}

function dibbling(videoId) {
    var promise_post_list = $.ajax({
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
    if(e['status'] == 1) {
        console.log('send');
        // ws.send("{id:"+e['videoId']+",title:"+e['title']+"}");
    }
    refreshList();
    refreshPlayedList();
    console.log(e);
}

function FailMethod(e) {
    alert(e);
    console.log(e);
}
