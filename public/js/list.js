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
                play_list_dom.append("<li class='list-group-item'>"+__('web.list.NoData')+"</li>");
            } else {
                // have video list and append video list
                db_list.forEach(function (e) {
                    play_list_dom.append(playListRow(e['video_id'], e['id'], e['title'], e['duration'], e['name']));
                });
            }
        });
    }

    function playListRow(video_id, id, title, duration, name) {
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
        let newButtonTime = document.createElement('button');
        newButtonTime.className = 'btn btn-dark';
        newButtonTime.setAttribute('type', 'button');
        newButtonTime.append(timeStamp(duration));
        let newButton1 = document.createElement('button');
        newButton1.className = 'btn btn-secondary';
        newButton1.setAttribute('type', 'button');
        newButton1.setAttribute('data-uid', id);
        newButton1.append(__('web.list.Cut'));
        let newButton2 = document.createElement('button');
        newButton2.className = 'btn btn-danger';
        newButton2.setAttribute('type', 'button');
        newButton2.setAttribute('data-uid', id);
        newButton2.append(__('web.list.Remove'));
        let nameSpan = document.createElement('span');
        nameSpan.append(name);
        nameSpan.className = 'badge badge-primary';
        let titleSpan = document.createElement('span');

        btn_group.append(newButtonTime);
        btn_group.append(newButton1);
        btn_group.append(newButton2);
        titleSpan.append(title);
        li.append(btn_group);
        li.append(nameSpan);
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
        refreshList();
    }
    refresh();
});
