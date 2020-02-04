
// dibbling
$(document).on('click', '.command', function (e) {
    var command = $(this).val();
    $.ajax({
        url: 'api/v2/command/',
        headers: {
            'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        dataType: "json",
        data: {
            'command': command,
        },
    });
});
