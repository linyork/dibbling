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

    function refreshList() {
        let list = $.ajax({
            url: '/api/v2/list',
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content')
            },
            method: "GET"
        });

        list.done(function (db_list) {
            $("#list").empty();
            $("#list").append(db_list)
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

    function refresh() {
        refreshList();
    }
    refresh();
});
