$(function() {
    // remove
    $(document).on('click', '.js-cut', function () {
        remove($(this).attr('data-uid'));
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

    function refreshLike() {
        $.ajax({
            url: '/api/v2/list/liked',
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST"
        }).done(function (db_list) {
            $("#like").empty();
            $("#like").append(db_list)
            $(".js-like").tooltip();
        });
    }

    function remove(id) {
        $.ajax({
            url: 'api/v2/list/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: "json",
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
        var button = $(obj);
        $.ajax({
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
        }).done(function (result) {
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
        refreshLike();
    }
    refresh();
});
