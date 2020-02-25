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

    // like
    $(document).on('click', '.js-like', function () {
        like($(this).attr('data-uid'), this);
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

    function like(id, obj) {
        var button = $(obj);
        var like = $.ajax({
            url: 'api/v2/like',
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json",
            data: {
                'videoId': id,
            },
        });
        like.done(function (result) {
            if(result['like']) {
                button.find('span').text(parseInt(button.find('span').text())+1);
                button.find('i').removeClass('fas');
                button.find('i').removeClass('far');
                button.find('i').addClass('fas');
            } else {
                button.find('span').text(parseInt(button.find('span').text())-1);
                button.find('i').removeClass('fas');
                button.find('i').removeClass('far');
                button.find('i').addClass('far');
            }
        });
    }

    function refresh() {
        refreshListPlayed();
    }

    refresh();
});
