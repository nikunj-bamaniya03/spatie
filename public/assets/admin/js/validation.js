// create permission validation
$(document).ready(function () {
    $('#create-pemission').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Permission Name is Required"
            }
        },
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "p",
        submitHandler: function (form) {
            form.submit();
        }
    });

    // create permission validation
    $('#edit-permission').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Permission Name is Required"
            }
        },
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "p",
        submitHandler: function (form) {
            form.submit();
        }
    });

    // create role validation
    $('#create-role').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Role Name is Required"
            }
        },
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "p",
        submitHandler: function (form) {
            form.submit();
        }
    });

    // create role validation
    $('#edit-role').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Role Name is Required"
            }
        },
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "p",
        submitHandler: function (form) {
            form.submit();
        }
    });


});
