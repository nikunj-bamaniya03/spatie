/*
* script for delete permission
*/

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-permission', function (e) {
    e.preventDefault();

    let permissionId = $(this).data('id');
    let url = permissionDestroyUrl.replace(':id', permissionId);

    if (!confirm('Are you sure you want to delete this permission?')) return;

    $.ajax({
        url: url,
        type: 'DELETE',
        success: function (response) {
            if (response.status) {
                alert(response.message);
                location.reload();
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            alert('Something went wrong!');
        }
    });
});
