//$(function (){

    const apiPath = 'api/v2/'
    const headers = {
        'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    // played dibbling
    $(document).on('click', '.js-dibbling', function () {
        redibbling($(this).attr('data-uid'));
        $(this).parents(".col-12").remove();
    })

    // remove
    $(document).on('click', '.js-cut', function () {
        remove($(this).attr('data-uid'));
        $(this).parents(".col-12").remove();
    })

    // real remove
    $(document).on('click', '.js-remove', function () {
        remove($(this).attr('data-uid'), true);
        $(this).parents(".col-12").remove();
    })

    // like
    $(document).on('click', '.js-like', function () {
        like($(this).attr('data-uid'), this);
    })


    function redibbling(id) {
        $.ajax({
            url: apiPath + 'list/' + id,
            headers: headers,
            type: "PUT",
            dataType: "json",
        })
    }

    function remove(id, realRemove = false) {
        $.ajax({
            url: apiPath + 'list/' + id,
            headers: headers,
            type: "DELETE",
            dataType: "json",
            data: {
                'real': realRemove
            }
        })
    }

    function like(id, obj) {
        let button = $(obj)
        $.ajax({
            url: apiPath + 'like',
            headers: headers,
            method: "POST",
            dataType: "json",
            data: {
                'videoId': id
            },
        }).done(function (result) {
            if (result['like']) {
                button.find('span').text(parseInt(button.find('span').text()) + 1)
                button.find('i').removeClass('far').addClass('fas')
            } else {
                button.find('span').text(parseInt(button.find('span').text()) - 1)
                button.find('i').removeClass('fas').addClass('far')
            }
        })
    }

//})
