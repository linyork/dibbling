var list = function () {

    const apiPath = '/api/v2/'
    let page = 1
    let limit = 12
    let isAjax = false
    let listContainer = '#record-list'
    let activePage = 'list'
    let main_user_id = 0
    let user_id = typeof($("#user_id").val()) === 'undefined' ? 0 : $("#user_id").val()
    let orderBy = 'default'
    let initStartDate = ''
    let initEndDate = ''
    let headers = {
        'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    // reset search bar
    $(document).on('click', '#reset', function () {
        user_id = main_user_id
        $("#user_id").val(user_id)
        $("#song_name").val("")
        $(".start-date").val(initStartDate)
        $(".end-date").val(initEndDate)
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

    //timeline
    $(document).on('click', '.dt-year', function() {
        slidePanel('.dd-y-' + $(this).data('val'))
    })

    $(document).on('click', '.dt-month', function() {
        slidePanel('.dd-m-' + $(this).data('val'))
    })

    $(document).on('click', '.events-header', function() {
        $(this).next().slideToggle(300)
    })

    $(document).on('click', '.collapse-all', function() {
        slidePanel('dd')
    })

    function slidePanel(className) {
        var status  = $(className)[0].style.display
        if (status == 'none') {
            $(className).slideDown(300)
        } else {
            $(className).slideUp(300)
        }
    }

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
            case 'timeline':
                refreshTimeline()
                break;
            default:
                break
        }
    }

    // scroll
    $(window).on('scroll', function () {
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

            var title = '<span style="font-size:1.2rem"> ' + obj.data('title') + ' </span>'
            var html = '<p style="padding-left:20px">' + '<ul style="padding-left:1.5rem">'
            var info = obj.data('played')
            result.forEach(item => {
                html += ('<li class="fas type' + (item.record_type ?? '') + '">  ' + item.created_at + ' - ' + item.name + ' ' + item.type_txt + '</li>')
            })
            html += '</ul></p>'
            modal.find('.modal-title').html(title)
            modal.find('.modal-body').html(html)
            modal.find('.modal-footer .info').html(info)
            if (!info) {
                modal.find('.modal-footer div').addClass('hidden')
            }
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
                'user_id': $("#user_id").val(),
                'song_name': $("#song_name").val(),
            }
        }).done(function (db_list) {
            updatePageList(db_list)
        })
    }

    function updatePageList(db_list){
        isAjax = false
        if (db_list.indexOf('no-data') == -1 || $(listContainer).html() == '') {
            if (activePage == 'timeline') {
                db_list = checkSelectorElement($(listContainer).html(), db_list, 'dt-year')
                db_list = checkSelectorElement($(listContainer).html(), db_list, 'dt-month')
            }
            $(listContainer).append(db_list)
            page++
        }
        $(".js-like").tooltip()
    }

    function checkSelectorElement(originHtml, appendHtml, className) {
        let originDiv = document.createElement('div')
        let appendDiv = document.createElement('div')
        originDiv.innerHTML = originHtml
        appendDiv.innerHTML = appendHtml
        var searchDiv = originDiv.getElementsByClassName(className)
        if (searchDiv.length > 0) {
            //get exist value
            var dataVals = []
            for (var i=0; i < searchDiv.length; i++) {
                dataVals.push(searchDiv[i].dataset.val)
            }
            //check & replace
            alterDiv = appendDiv.getElementsByClassName(className)
            for (var i=0; i < alterDiv.length; i++) {
                if ($.inArray(alterDiv[i].dataset.val, dataVals) != -1) {
                    alterDiv[i].remove()
                }
            }
        }
        return appendDiv.innerHTML
    }

    function refreshTimeline() {
        isAjax = true
        $.ajax({
            url: apiPath + 'timeline',
            headers: headers,
            method: "POST",
            data: {
                'page': page,
                'start_date': $(".start-date").val(),
                'end_date': $(".end-date").val(),
                'order': $(".order-list").val() ?? '0',
            }
        }).done(function (db_list) {
            if (!db_list['msg']) {
                updatePageList(db_list)
            } else {
                alert(db_list['msg'])
            }
        })
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
            main_user_id = $('#user_id').val()
        },
        initTimeline: function(container){
            listContainer = container ?? listContainer
            activePage = 'timeline'
            refreshTimeline()
            initStartDate = $(".start-date").val()
            initEndDate = $(".end-date").val()
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
