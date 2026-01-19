$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-user', function (e) {
    e.preventDefault();

    let button = $(this);
    let table = $('#data-table').DataTable();
    let row = button.closest('tr');

    let roleId = button.data('id');
    let url = destroyUserUrl.replace(':id', roleId);

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
            $.ajax({
                url: url,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.status) {

                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {

                            // REMOVE ONLY THE DELETED ROW
                            table
                                .row(row)
                                .remove()
                                .draw(false); // keep pagination
                        });
                    }
                },

                error: function () {
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
