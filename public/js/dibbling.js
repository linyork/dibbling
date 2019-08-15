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
        ws.send("{id:"+e['videoId']+",title:"+e['title']+"}");
    }
    alert(e['msg']);
    console.log(e);
}

function FailMethod(e) {
    alert(e);
    console.log(e);
}
