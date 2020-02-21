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

    var isAjax = false;
    $(window).scroll(function(){
        if (isAjax) return;
        if ($(document).height() - $(this).scrollTop() - $(this).height()<100) refreshListPlayedPage();
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
            url: '/api/v2/list/played/1',
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

    var page = 2;
    function refreshListPlayedPage() {
        isAjax = true;
        let promise_get_list = $.ajax({
            url: '/api/v2/list/played/'+page,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
            },
            method: "GET"
        });
        promise_get_list.done(function (db_list) {
            isAjax = false;
            $("#record-list").append(db_list);
            if(db_list) page = page +1;
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
