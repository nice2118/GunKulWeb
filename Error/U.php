<!DOCTYPE html>
<html>
<head>
  <title>Upload Images</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .image-container {
      display: flex;
      flex-wrap: wrap;
    }

    .image-preview {
      position: relative;
      width: 100px;
      height: 100px;
      margin: 10px;
      border-radius: 50%;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      cursor: pointer;
    }

    .image-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .delete-image-btn {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(0, 0, 0, 0.7);
      background-size: cover;
      color: #ddd;
      border: none;
      padding: 50px;
      font-size: 25px;
      cursor: pointer;
      display: none;
    }

    .image-preview:hover .delete-image-btn {
      display: block;
    }

    .add-image-btn, .delete-all-btn {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mt-5">Upload Images</h1>
    <div class="image-container"></div>
    <input type="file" class="image-input" accept="image/*, video/*" style="display: none;" multiple>
    <button class="btn btn-primary add-image-btn">Add Images</button>
    <button class="btn btn-danger delete-all-btn">Delete All</button>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
  <script>
    // Add event listener to the "Add Images" button
    const addImageBtn = document.querySelector('.add-image-btn');
    const imageInput = document.querySelector('.image-input');
    const imageContainer = document.querySelector('.image-container');
    const deleteAllBtn = document.querySelector('.delete-all-btn');

    addImageBtn.addEventListener('click', () => {
      imageInput.click();
    });

    // Handle image selection
    imageInput.addEventListener('change', () => {
      // Loop through selected files
      for (const file of imageInput.files) {
        const reader = new FileReader();

        // Create image preview
        const imagePreview = document.createElement('div');
        imagePreview.classList.add('image-preview');

        reader.onload = (e) => {
          // Set image source as the selected file
          const image = document.createElement('img');
          image.src = e.target.result;
          image.alt = file.name;

          // Append the image to the preview container
          imagePreview.appendChild(image);

          // Create delete button
          const deleteButton = document.createElement('button');
          deleteButton.classList.add('delete-image-btn', 'fa', 'fa-close');

          // Add event listener to the delete button
          deleteButton.addEventListener('click', () => {
            imagePreview.remove();
          });

          // Append the delete button to the preview container
          imagePreview.appendChild(deleteButton);

          // Append the image preview to the image container
          imageContainer.appendChild(imagePreview);
        };

        reader.readAsDataURL(file);
      }
    });

    // Handle delete all button
    deleteAllBtn.addEventListener('click', () => {
      const imagePreviews = imageContainer.querySelectorAll('.image-preview');
      imagePreviews.forEach((imagePreview) => {
        imagePreview.remove();
      });
    });
  </script>
</body>
</html>