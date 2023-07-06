<!DOCTYPE html>
<html>
<head>
  <title>Upload Images</title>
  <style>
    .image-container {
      display: flex;
      flex-wrap: wrap;
    }

    .image-preview {
      position: relative;
      width: 150px;
      height: 150px;
      margin: 10px;
      border: 1px solid #ddd;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .image-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .delete-image-btn {
      position: absolute;
      top: 5px;
      right: 5px;
      background-color: #ff0000;
      color: #fff;
      border: none;
      padding: 5px;
      font-size: 14px;
      cursor: pointer;
    }

    .image-input {
      display: none;
    }

    .add-image-btn {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h1>Upload Images</h1>
  <div class="image-container">
    <div class="image-preview">
      <img src="image1.jpg" alt="Image 1">
      <button class="delete-image-btn">&times;</button>
    </div>
    <div class="image-preview">
      <img src="image2.jpg" alt="Image 2">
      <button class="delete-image-btn">&times;</button>
    </div>
    <div class="image-preview">
      <img src="image3.jpg" alt="Image 3">
      <button class="delete-image-btn">&times;</button>
    </div>
  </div>
  <input type="file" class="image-input" multiple>
  <button class="add-image-btn">Add Images</button>

  <script>
    // Add event listener to the "Add Images" button
    const addImageBtn = document.querySelector('.add-image-btn');
    const imageInput = document.querySelector('.image-input');
    addImageBtn.addEventListener('click', () => {
      imageInput.click();
    });

    // Handle image selection
    imageInput.addEventListener('change', () => {
      const imageContainer = document.querySelector('.image-container');

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
          // deleteButton.classList.add('delete-image-btn');
          deleteButton.classList.add('btn-close btn-close-white');
          deleteButton.innerHTML = '&times;';

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
  </script>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
  <title>หน้าเว็บ</title>
  <style>
    #previewImage {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
  <input type="file" id="imageInput" accept="image/*">
  <img id="previewImage" src="" alt="ภาพตัวอย่าง">

  <script>
    var imageInput = document.getElementById('imageInput');
    var previewImage = document.getElementById('previewImage');

    // เมื่อมีการเลือกไฟล์
    imageInput.addEventListener('change', function(event) {
      var file = event.target.files[0];
      
      if (file) {
        var reader = new FileReader();

        // อ่านไฟล์และแสดงภาพตัวอย่าง
        reader.onload = function(e) {
          previewImage.src = e.target.result;
        }

        reader.readAsDataURL(file);
      } else {
        previewImage.src = ''; // รีเซ็ตภาพตัวอย่างเมื่อไม่มีไฟล์ที่เลือก
      }
    });
  </script>
</body>
</html>
