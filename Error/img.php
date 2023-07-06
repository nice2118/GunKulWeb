<!DOCTYPE html>
<html>
<head>
  <title>Image Import</title>
</head>
<body>
  <?php
  // ตรวจสอบว่าได้เลือกไฟล์ภาพหรือไม่
  if(isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // ตรวจสอบว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
    if($file['error'] === 0) {
      $fileName = $file['name'];
      $fileTmp = $file['tmp_name'];
      $fileType = $file['type'];

      // ตรวจสอบประเภทของไฟล์ภาพ
      if($fileType === 'image/jpeg' || $fileType === 'image/png') {
        // กำหนดโฟลเดอร์ที่ต้องการบันทึกไฟล์ภาพ
        $uploadPath = 'img/UploadsImgNews/' . $fileName;

        // ย้ายไฟล์ภาพไปยังโฟลเดอร์ที่กำหนด
        move_uploaded_file($fileTmp, $uploadPath);

        echo "Image imported successfully.";
      } else {
        echo "Invalid image format. Please upload JPEG or PNG image.";
      }
    } else {
      echo "Error uploading image. Please try again.";
    }
  }
  ?>

  <h1>Image Import</h1>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*">
    <br>
    <input type="submit" value="Import">
  </form>
</body>
</html>