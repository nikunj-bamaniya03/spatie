$(document).ready(function () {

    // Load categories
    $.get('/categories', function (data) {
        data.forEach(cat => {
            $('#category').append(`<option value="${cat.id}">${cat.name}</option>`);
        });
    });

    // Load products by category
    $('#category').change(function () {
        let categoryId = $(this).val();
        $('#product').html('<option value="">Loading...</option>');

        $.get('/products/by-category/' + categoryId, function (products) {
            $('#product').html('<option value="">Select Product</option>');
            products.forEach(p => {
                $('#product').append(`<option value="${p.id}">${p.name}</option>`);
            });
        });
    });

});
