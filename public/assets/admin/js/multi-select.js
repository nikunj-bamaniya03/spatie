// new TomSelect("#category-select", {
//     plugins: [
//         'checkbox_options',
//         'remove_button'
//     ],
//     maxItems: null,
//     create: false,
// });

document.addEventListener('DOMContentLoaded', function () {

    ['#role_filter', '#category-select'].forEach(function (selector) {

        const el = document.querySelector(selector);

        if (!el) return;            // element not on page
        if (el.tomselect) return;   // already initialized

        new TomSelect(el, {
            plugins: [
                'checkbox_options',
                'remove_button'
            ],
            maxItems: null,
            create: false,
            hideSelected: false,
            closeAfterSelect: false
        });
    });

});

