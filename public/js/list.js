var list = function () {

    const apiPath = 'api/v2/'
    let page = 1
    let limit = 12
    let isAjax = false
    let listContainer = '#record-list'
    let activePage = 'list'
    let user_id = 0
    let orderBy = 'default'
    let headers = {
        'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    // reset search bar
    $(document).on('click', '#reset', function () {
        user_id = 0
        $("#user_id").val(user_id)
        $("#song_name").val("")
        resetContainer()
    })

    // search search bar
    $(document).on('click', '#search', function () {
        resetContainer()
    })
    $(document).on('keydown', '#song_name', function (e) {
        if (e.which === 13) {
            resetContainer()
        }
    })
    $(document).on('keydown', '#user_id', function (e) {
        if (e.which === 13) {
            resetContainer()
        }
    })

    $(document).on('click', '.js-record-name', function () {
        user_id = $(this).attr('data-uid') ?? 0
        $("#user_id").val(user_id)
        resetContainer()
    })

    function resetContainer(){
        page = 1
        user_id = typeof($("#user_id").val()) === 'undefined' ? user_id : $("#user_id").val()
        orderBy = $(".order-list").val() ?? 'default'
        $(listContainer).empty()
        ajaxContainer()
    }
    
    function ajaxContainer(){
        switch (activePage) {
            case 'list':
                refreshList()
                break
            case 'listPlayed':
                refreshListPlayed()
                break
            case 'listLiked':
                refreshListLiked()
                break
            default:
                break
        }
    }
    
    // scroll
    $(window).scroll(function () {
        if (isAjax) return;
        if ($(document).height() - $(this).scrollTop() - $(this).height() < 100) ajaxContainer();
    })


    function reDibbling(id, obj) {
        $.ajax({
            url: apiPath + 'list/' + id,
            headers: headers,
            type: "PUT",
            dataType: "json"
        }).done(function (result) {
            removeContain(obj)
        })
    }

    function remove(id, obj, realRemove = false) {
        $.ajax({
            url: apiPath + 'list/' + id,
            headers: headers,
            type: "DELETE",
            dataType: "json",
            data: {
                'real': realRemove
            }
        }).done(function (result) {
            removeContain(obj)
        })
    }

    function removeContain(obj){
        obj.parents(".col-12").remove()
    }

    function like(id, obj) {
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
                obj.find('span').text(parseInt(obj.find('span').text()) + 1)
                obj.find('i').removeClass('far').addClass('fas')
            } else {
                obj.find('span').text(parseInt(obj.find('span').text()) - 1)
                obj.find('i').removeClass('fas').addClass('far')
            }
        })
    }

    function info(id, obj) {
        $.ajax({
            url: apiPath + 'info',
            headers: headers,
            method: "POST",
            dataType: "json",
            data: {
                'list_id': id
            }
        }).done(function (result) {
            var modal = $('#infoModal')
            
            var html = '<p style="padding-left:20px"><i class="fa fa-info-circle"></i> ' + obj.data('title') + '</p>' + '<ul>'
            result.forEach(item => {
                html += ('<li>' + item.created_at + ' - ' + item.name + ' ' + item.type_txt + '</li>')
            })
            html += '</ul>'
            modal.find('.modal-body').html(html)
            modal.modal('show')
        })
    }


    function refreshList() {
        isAjax = true
        $.ajax({
            url: apiPath + 'list',
            headers: headers,
            method: "GET",
            data: {
                'page': page,
                'limit': limit,
                'order': orderBy
            }
        }).done(function (db_list) {
            updatePageList(db_list)
        })
    }

    function refreshListPlayed() {
        isAjax = true
        $.ajax({
            url: apiPath + 'list/played',
            headers: headers,
            method: "POST",
            data: {
                'page': page,
                'limit': limit,
                'order': orderBy,
                'user_id': user_id,
                'song_name': $("#song_name").val(),
            }
        }).done(function (db_list) {
            updatePageList(db_list)
        })
    }

    function refreshListLiked() {
        isAjax = true
        $.ajax({
            url: apiPath + 'list/liked',
            headers: headers,
            method: "POST",
            data: {
                'page': page,
                'limit': limit,
                'order': orderBy,
                'user_id': user_id
            }
        }).done(function (db_list) {
            updatePageList(db_list)
        })
    }

    function updatePageList(db_list){
        isAjax = false
        $(listContainer).append(db_list)
        $(".js-like").tooltip()
        if (db_list) page++
    }


    return {
        //init
        init: function(container){
            listContainer = container ?? listContainer
            activePage = 'list'
            refreshList()
        },
        initPlayed: function(container){
            listContainer = container ?? listContainer
            activePage = 'listPlayed'
            refreshListPlayed()
        },
        initLiked: function(container){
            listContainer = container ?? listContainer
            activePage = 'listLiked'
            refreshListLiked()
        },
        //trigger
        reDibbling: function(id, obj){
            reDibbling(id, $(obj))
        },
        remove: function(id, obj){
            remove(id, $(obj), true)
        },
        cut: function(id, obj){
            remove(id, $(obj), false)
        },
        like: function(id, obj){
            like(id, $(obj))
        },
        info: function(id, obj){
            info(id, $(obj))
        }
    }
}()
