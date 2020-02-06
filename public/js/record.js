$(function() {
    // played dibbling
    $(document).on('click', '.btn-primary', function () {
        redibbling($(this).attr('data-uid'));
    });

    // real remove
    $(document).on('click', '.btn-danger', function () {
        realRemove($(this).attr('data-uid'));
    });

    function redibbling(id){
        let promise_remove = $.ajax({
            url: 'api/v2/list/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "PUT",
            dataType: "json",
        });

        promise_remove.done(function () {
            refresh();
        });
    }

    function refreshListPlayed() {
        let promise_get_list = $.ajax({
            url: '/api/v2/list/played',
            method: "GET"
        });

        promise_get_list.done(function (db_list) {
            let played_list_dom = $("#played-list");
            played_list_dom.empty();
            if (db_list.length <= 0) {
                // no video list
                played_list_dom.append("<li class='list-group-item'>無已播清單</li>");
            } else {
                // have video list and append video list
                db_list.forEach(function (e) {
                    played_list_dom.append(playedListRow(e['video_id'], e['id'], e['title'], e['name']));
                });
            }

        });
    }

    function playedListRow(video_id, id, title, name) {
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
        newButton1.className = 'btn btn-primary';
        newButton1.setAttribute('type', 'button');
        newButton1.setAttribute('data-uid', id);
        newButton1.append(__('web.record.Dibbling'));
        let newButton2 = document.createElement('button');
        newButton2.className = 'btn btn-danger';
        newButton2.setAttribute('type', 'button');
        newButton2.setAttribute('data-uid', id);
        newButton2.append(__('web.record.Remove'));
        let nameSpan = document.createElement('span');
        nameSpan.append(name);
        nameSpan.className = 'badge badge-primary';
        let titleSpan = document.createElement('span');

        btn_group.append(newButton1);
        btn_group.append(newButton2);
        titleSpan.append(title);
        li.append(btn_group);
        li.append(nameSpan);
        li.append(titleSpan);

        return li;
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
        refreshListPlayed();
    }

    refresh();
});
