$(function() {
    // remove
    $(document).on('click', '.btn-secondary', function () {
        remove($(this).attr('data-uid'));
    });

    // real remove
    $(document).on('click', '.btn-danger', function () {
        realRemove($(this).attr('data-uid'));
    });

    function refreshList() {
        let list = $.ajax({
            url: '/api/v2/list',
            method: "GET"
        });

        list.done(function (db_list) {
            let play_list_dom = $('#list');
            play_list_dom.empty();
            if (db_list.length <= 0) {
                // no video list
                play_list_dom.append("<li class='list-group-item'>No data</li>");
            } else {
                // have video list and append video list
                db_list.forEach(function (e) {
                    play_list_dom.append(playListRow(e['video_id'], e['id'], e['title']));
                });
            }
        });
    }

    function playListRow(video_id, id, title) {
        let li = document.createElement('li');
        li.className = 'list-group-item text-truncate';
        li.setAttribute('data-toggle', 'tooltip');
        li.setAttribute('data-placement', 'top');
        li.setAttribute('title', title);
        let btn_group = document.createElement('div');
        btn_group.className = 'btn-group';
        btn_group.setAttribute('role', 'group');
        btn_group.setAttribute('aria-label', 'Basic example');
        btn_group.setAttribute('style', 'margin-right: 1em;');
        let newButton1 = document.createElement('button');
        newButton1.className = 'btn btn-secondary';
        newButton1.setAttribute('type', 'button');
        newButton1.setAttribute('data-uid', id);
        newButton1.append('切歌');
        let newButton2 = document.createElement('button');
        newButton2.className = 'btn btn-danger';
        newButton2.setAttribute('type', 'button');
        newButton2.setAttribute('data-uid', id);
        newButton2.append('移除');
        let titleSpan = document.createElement('span');

        btn_group.append(newButton1);
        btn_group.append(newButton2);
        titleSpan.append(title);
        li.append(btn_group);
        li.append(titleSpan);
        return li;
    }

    function remove(id) {
        let promise_remove = $.ajax({
            url: 'api/v2/list/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: "json",
        });

        promise_remove.done(function () {
            refresh();
        });
    }

    function realRemove(id) {
        let promise_remove = $.ajax({
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

        promise_remove.done(function () {
            refresh();
        });
        console.log(id);
    }


    function refresh() {
        refreshPlaying();
        refreshList();
    }
    refresh();
});
