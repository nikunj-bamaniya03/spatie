// create role validation

$(document).ready(function () {
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

    // edit role validation
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

    // create-product validation

    $('#create-product').validate({
        rules: {
            category_id: {
                required: true
            },
            product_name: {
                required: true,
                minlength: 2
            },
            product_description: {
                maxlength: 200
            },
            product_price: {
                required: true,
                number: true,
                min: 0
            },
            product_image: {
                required: true,
                extension: "jpg|jpeg|png"
            }
        },

        messages: {
            category_id: {
                required: "Please select a category"
            },
            product_name: {
                required: "Please enter the product name",
                minlength: "Product name must be at least 2 characters"
            },
            product_description: {
                maxlength: "Maximum 200 characters allowed"
            },
            product_price: {
                required: "Please enter product price",
                number: "Please enter a valid number",
                min: "Price must be greater than or equal to 0"
            },
            product_image: {
                required: "Please select a product image",
                extension: "Only JPG, PNG, JPEG images are allowed"
            }
        },
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "p",
        submitHandler: function (form) {
            form.submit();
        }
    });

    // edit-product validation

    $('#edit-product').validate({
        rules: {
            category_id: {
                required: true
            },
            product_name: {
                required: true,
                minlength: 2
            },
            product_description: {
                maxlength: 200
            },
            product_price: {
                required: true,
                number: true,
                min: 0
            },
            product_image: {
                // required: true,
                extension: "jpg|jpeg|png"
            }
        },

        messages: {
            category_id: {
                required: "Please select a category"
            },
            product_name: {
                required: "Please enter the product name",
                minlength: "Product name must be at least 2 characters"
            },
            product_description: {
                maxlength: "Maximum 200 characters allowed"
            },
            product_price: {
                required: "Please enter product price",
                number: "Please enter a valid number",
                min: "Price must be greater than or equal to 0"
            },
            product_image: {
                // required: "Please select a product image",
                extension: "Only JPG, PNG, JPEG images are allowed"
            }
        },
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "p",
        submitHandler: function (form) {
            form.submit();
        }
    });


    // add-user validation

    $('#create-user').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
            password_confirmation: {
                required: true,
                equalTo: '#password'
            },
            role_id: {
                required: true,
                number: true,
            },
        },

        messages: {
            name: {
                required: "Please enter your name",
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address",
            },
            password: {
                required: "Please enter a password",
                minlength: "Password must be at least 8 characters",
            },
            password_confirmation: {
                required: "Please confirm your password",
                equalTo: "Passwords do not matchssssss"
            },
            role_id: {
                required: "Please select a role",
                number: "Role must be a valid number",
            },
        },
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "p",
        submitHandler: function (form) {
            form.submit();
        }
    });
});
