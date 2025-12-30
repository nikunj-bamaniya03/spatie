/*
* script for delete role
*/

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-role', function (e) {
    e.preventDefault(); //stop the reloading and default behaviour of browser

    let roleId = $(this).data('id');
    let url = roleDestroyUrl.replace(':id', roleId);

    if (!confirm('Are you sure you want to delete this role?')) return;

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
