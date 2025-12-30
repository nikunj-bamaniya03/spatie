document.querySelectorAll('.image-uploader').forEach(wrapper => {

    const fileInput  = wrapper.querySelector('.image-input');
    const mainImage  = wrapper.querySelector('.main-image');
    const removeBtn  = wrapper.querySelector('.remove-image');
    const removeFlag = wrapper.querySelector('.remove-flag');

    const modal      = wrapper.querySelector('.image-modal');
    const zoomImage  = wrapper.querySelector('.zoom-image');
    const closeModal = wrapper.querySelector('.close-modal');

    // show remove button if image exists
    if (mainImage.src) {
        removeBtn.classList.remove('hidden');
    }

    // preview new image
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            mainImage.src = e.target.result;
            removeBtn.classList.remove('hidden');
            removeFlag.value = 0;
        };
        reader.readAsDataURL(file);
    });

    // remove image
    removeBtn.addEventListener('click', e => {
        e.stopPropagation(); // stop the default action
        mainImage.src = '';   // image remove from UI
        fileInput.value = '';  //image file reset
        removeBtn.classList.add('hidden'); // remove button hide
        removeFlag.value = 1; // 1- remove image and 0- say image
    });

    // zoom image
    mainImage.addEventListener('click', () => {
        if (!mainImage.src) return;
        zoomImage.src = mainImage.src; // image open in zoom model
        modal.classList.remove('hidden'); // model visible
    });

    // close zoom
    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');  // close model when click on X button
    });

    modal.addEventListener('click', e => {
        if (e.target === modal) { 
            modal.classList.add('hidden');   // if click black background than close model
        }
    });

});
