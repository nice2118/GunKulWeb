<script>
        // Add event listener to the "Add Images" button
        const addImageBtn = document.querySelector('.add-image-btn');
        const imageGallery = document.querySelector('.Image-Gallery');
        const imageContainer = document.querySelector('.image-container');
        const deleteAllBtn = document.querySelector('.delete-all-btn');

        addImageBtn.addEventListener('click', () => {
            imageGallery.click();
        });

        // Handle image selection
        imageGallery.addEventListener('change', () => {
        // Loop through selected files
            for (const file of imageGallery.files) {
                const reader = new FileReader();

                // Create image preview
                const imagePreview = document.createElement('div');
                imagePreview.classList.add('image-preview');
                imagePreview.classList.add('loading');

                // Create loading text
                const loadingText = document.createElement('div');
                loadingText.classList.add('d-flex', 'justify-content-center', 'align-items-center', 'text-primary', 'my-4');
                loadingText.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';

                // Append loading text to the preview container
                imagePreview.appendChild(loadingText);

                reader.onload = (e) => {
                    // Set image source as the selected file
                    const image = document.createElement('img');
                    const video = document.createElement('video');

                    if (file.type.startsWith('image/')) {
                        // For image files, use the file itself as the source
                        image.src = e.target.result;
                        image.alt = file.name;

                        // Append the image to the preview container
                        imagePreview.appendChild(image);
                    } else if (file.type.startsWith('video/')) {
                        // For video files, create a video element and set the source
                        video.src = e.target.result;
                        video.alt = file.name;
                        video.controls = true;
                        video.muted = true;
                        video.loop = true;

                        // Append the video to the preview container
                        imagePreview.appendChild(video);

                        // Add event listener to play the video when it's loaded
                        video.addEventListener('loadeddata', () => {
                            video.play();
                        });
                    }

                    // Create delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('delete-image-btn', 'fa', 'fa-times');

                    // Add event listener to the delete button
                    deleteButton.addEventListener('click', (event) => {
                        const imagePreview = event.currentTarget.parentNode;
                        const imageContainer = imagePreview.parentNode;
                        const selectedFile = imagePreview.querySelector('img, video').alt;

                        // Remove the image preview from the image container
                        imageContainer.removeChild(imagePreview);

                        // Remove the file from the input's files array
                        const updatedFiles = Array.from(imageGallery.files).filter((file) => file.name !== selectedFile);
                        const updatedFileList = new DataTransfer();
                        updatedFiles.forEach((file) => {
                            updatedFileList.items.add(file);
                        });
                        imageGallery.files = updatedFileList.files;
                    });

                    // Append the delete button to the preview container
                    imagePreview.appendChild(deleteButton);

                    // Append the image preview to the image container
                    imageContainer.appendChild(imagePreview);

                    // Remove loading text when loading is complete
                    imagePreview.removeChild(loadingText);
                };

                reader.readAsDataURL(file);

                // Append the image preview to the image container
                imageContainer.appendChild(imagePreview);
            }
        });

        // Handle delete all button
        deleteAllBtn.addEventListener('click', () => {
        const imagePreviews = imageContainer.querySelectorAll('.image-preview');
            imagePreviews.forEach((imagePreview) => {
                imagePreview.remove();
            });
            imageGallery.value = '';
        });
    </script>