document.getElementById('product_image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById('preview_image').src = event.target.result;
            document.getElementById('preview_container').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});