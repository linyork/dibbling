$(function () {
    let page = 1;
    let isAjax = false;

    // reset search bar
    $(document).on('click', '#reset', function () {
        page = 1;
        $("#record-list").empty();
        $("#user_id").val(0);
        $("#song_name").val("");
        refreshListPlayed();
    });

    // search search bar
    $(document).on('click', '#search', function () {
        page = 1;
        $("#record-list").empty();
        refreshListPlayed();
    });

    $(document).on('click', '.js-record-name', function () {
        page = 1;
        $("#record-list").empty();
        $("#user_id").val($(this).attr('data-uid'));
        refreshListPlayed();
    });

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

    // scroll
    $(window).scroll(function () {
        if (isAjax) return;
        if ($(document).height() - $(this).scrollTop() - $(this).height() < 100) refreshListPlayed();
    });

    function redibbling(id) {
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
        isAjax = true;
        let promise_get_list = $.ajax({
            url: '/api/v2/list/played',
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            data: {
                'page': page,
                'user_id': $("#user_id").val(),
                'song_name': $("#song_name").val(),
            },
        });
        promise_get_list.done(function (db_list) {
            isAjax = false;
            $("#record-list").append(db_list);
            $(".js-like").tooltip();
            if (db_list) page++;
        });
    }

    function realRemove(id) {
        $.ajax({
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
        let button = $(obj);
        let like = $.ajax({
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
            if (result['like']) {
                button.find('span').text(parseInt(button.find('span').text()) + 1);
                button.find('i').removeClass('fas');
                button.find('i').removeClass('far');
                button.find('i').addClass('fas');
            } else {
                button.find('span').text(parseInt(button.find('span').text()) - 1);
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
