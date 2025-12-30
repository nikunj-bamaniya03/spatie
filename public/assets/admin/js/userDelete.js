$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-user', function (e) {
    e.preventDefault();
    //stop the reloading and default behaviour of browser

    let roleId = $(this).data('id');
    let url = destroyUserUrl.replace(':id', roleId);

    // SweetAlert for confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, proceed with the AJAX request
            $.ajax({
                url: url, // Use your actual URL variable here
                type: 'DELETE',
                success: function (response) {
                    if (response.status) {
                        // SweetAlert for success message
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            // $('#data-table').DataTable().ajax.reload(null, false); // Reload the page after the alert is dismissed
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    // SweetAlert for error message
                    Swal.fire(
                        'Error!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    });
});
