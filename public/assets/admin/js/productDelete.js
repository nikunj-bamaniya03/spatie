$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-product', function (e) {
    e.preventDefault();

    let productId = $(this).data('id');
    let url = productDestroyUrl.replace(':id', productId);

    if (!confirm('Are you sure you want to delete this product?')) return;

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
            console.error(xhr.responseText);
            alert('Delete failed!');
        }
    });
});
