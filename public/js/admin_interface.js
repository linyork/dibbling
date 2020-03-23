$(function () {

    // delete
    $(document).on('click', '.delete', function () {
        let id = $(this).val();
        deleteUser(id);
    });

    function deleteUser(id) {
        let test = $.ajax({
            url: 'api/v2/user/delete/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE",
            dataType: "json"
        });

        test.done(function (result) {
            console.log(result);
        });

    }
});
