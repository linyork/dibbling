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

$(function() {
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
