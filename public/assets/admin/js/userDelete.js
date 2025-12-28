$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-record', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    let url = deleteUrl.replace(':id', id);

    if (!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: url,
        type: 'DELETE',
        success: function (response) {
            if (response.status === true) {
                alert(response.message);
                $('#row-' + id).fadeOut(300, function () {
                    $(this).remove();
                });
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('Delete failed!');
        }
    });
});
