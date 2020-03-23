$(function () {

    // delete
    $(document).on('click', '.delete', function () {
        let id = $(this).val();
        deleteUser(id);
    });

    function deleteUser(id) {
        let deleteUser = $.ajax({
            url: 'api/v2/user/delete/' + id,
            headers: {
                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "DELETE"
        });

        deleteUser.done(function (result) {
            if(result !== '0'){
                $("#user-"+id).remove();
            }
        });

    }
});
