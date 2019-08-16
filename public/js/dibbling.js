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

//refresh
$(document).on('click', '.btn-info', function(event){
    refreshList();
});

// refresh list
refreshList();
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
                $("#list").append("<li class='list-group-item' id='"+id+"' video_id='"+video_id+"'>"+title+"</li>");
            }
        } else {
            // no video list
            $("#list").empty();
            $("#list").append("<li class='list-group-item'>無點播清單</li>");
        }

    });
}

function dibbling(id) {
    var promise = $.ajax({
        url: '/dibbling/' + id,
        method: "GET",
        dataType: "json",
    });

    promise.done(SuccessMethod);
    promise.fail(FailMethod);
}

function SuccessMethod(e) {
    if(e['status'] == 1) {
        console.log('send');
        // ws.send("{id:"+e['videoId']+",title:"+e['title']+"}");
    }
    alert(e['msg']);
    refreshList();
    console.log(e);

}

function FailMethod(e) {
    alert(e);
    console.log(e);
}
