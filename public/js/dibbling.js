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

// played dibbling
$(document).on('click', '.btn-primary', function(){
    dibbling($(this).attr('data-id'));
});

// remove
$(document).on('click', '.btn-secondary', function(){
    remove($(this).attr('data-uid'));
});

// real remove
$(document).on('click', '.btn-danger', function(){
    realRemove($(this).attr('data-uid'));
});

//refresh
$(document).on('click', '.btn-info', function(){
    refresh();
});

// refresh playing & list & play list
$(function() {
    refresh();
});

function refresh(){
    refreshPlaying();
    refreshList();
    refreshListPlayed();
}

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
            db_list.forEach(function(e) {
                play_list_dom.append(playListRow(e['video_id'], e['id'], e['title']));
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
            db_list.forEach(function(e) {
                played_list_dom.append(playedListRow(e['video_id'], e['id'], e['title']));
            });
        }

    });
}

function dibbling(videoId) {
    if (videoId == '') return;
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

function remove(id) {
    let promise_remove = $.ajax({
        url: 'v1/list/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "DELETE",
        dataType: "json",
    });

    promise_remove.done(function(){
        refresh();
    });
}

function realRemove(id){
    let promise_remove = $.ajax({
        url: 'v1/list/' + id ,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "DELETE",
        dataType: "json",
        data: {
            'real': true,
        },
    });

    promise_remove.done(function(){
        refresh();
    });
    console.log(id);
}

function SuccessMethod(e) {
    if(e['status'] === 1) {
        console.log('send');
        // ws.send("{id:"+e['videoId']+",title:"+e['title']+"}");
    }
    refresh();
    console.log(e);
}

function FailMethod(e) {
    alert(e);
    console.log(e);
}

function playListRow(video_id, id, title) {
    let newLi = document.createElement('li');
    newLi.className = 'list-group-item';
    let newDiv = document.createElement('div');
    newDiv.className = 'btn-group';
    newDiv.setAttribute('role', 'group');
    newDiv.setAttribute('aria-label', 'Basic example');
    let newButton1 = document.createElement('button');
    newButton1.className = 'btn btn-secondary';
    newButton1.setAttribute('type', 'button');
    newButton1.setAttribute('data-uid', id);
    newButton1.append('切歌');
    let newButton2 = document.createElement('button');
    newButton2.className = 'btn btn-danger';
    newButton2.setAttribute('type', 'button');
    newButton2.setAttribute('data-uid', id);
    newButton2.append('移除');

    newDiv.append(newButton1);
    newDiv.append(newButton2);
    newLi.append(newDiv);
    newLi.append(title);

    return newLi;
}

function playedListRow(video_id, id, title) {
    let newLi = document.createElement('li');
    newLi.className = 'list-group-item';
    let newDiv = document.createElement('div');
    newDiv.className = 'btn-group';
    newDiv.setAttribute('role', 'group');
    newDiv.setAttribute('aria-label', 'Basic example');
    let newButton1 = document.createElement('button');
    newButton1.className = 'btn btn-primary';
    newButton1.setAttribute('type', 'button');
    newButton1.setAttribute('data-id', video_id);
    newButton1.append('點播');
    let newButton2 = document.createElement('button');
    newButton2.className = 'btn btn-danger';
    newButton2.setAttribute('type', 'button');
    newButton2.setAttribute('data-uid', id);
    newButton2.append('移除');

    newDiv.append(newButton1);
    newDiv.append(newButton2);
    newLi.append(newDiv);
    newLi.append(title);

    return newLi;
}
