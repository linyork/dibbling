$(function() {
    // played dibbling
    $(document).on('click', '.js-dibbling', function () {
        redibbling($(this).attr('data-uid'));
        $(this).parents(".col-12").remove();
    });

    // real remove
    $(document).on('click', '.js-remove', function () {
        realRemove($(this).attr('data-uid'));
        $(this).parents(".col-12").remove();
    });

    function redibbling(id){
        $.ajax({
            url: 'api/v2/list/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "PUT",
            dataType: "json",
        });
    }

    function refreshListPlayed() {
        let promise_get_list = $.ajax({
            url: '/api/v2/list/played',
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
            },
            method: "GET"
        });

        promise_get_list.done(function (db_list) {
            $("#record-list").empty();
            $("#record-list").append(db_list)
        });
    }

    function realRemove(id) {
        promise_remove = $.ajax({
            url: 'api/v2/list/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: "json",
            data: {
                'real': true,
            },
        });
    }

    function timeStamp( second_time ){

        var time = parseInt(second_time);
        if( parseInt(second_time )> 60){

            var second = parseInt(second_time) % 60;
            if(second < 10) second = "0"+second.toString();
            var min = parseInt(second_time / 60);
            time = min + ":" + second;
        }

        return time;
    }

    function refresh() {
        refreshListPlayed();
    }

    refresh();
});
