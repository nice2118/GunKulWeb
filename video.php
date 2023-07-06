<!DOCTYPE html>
<html>
<head>
  <title>Video Import</title>
</head>
<body>
  <?php
  // ตรวจสอบว่าได้เลือกไฟล์วิดีโอหรือไม่
  if(isset($_FILES['video'])) {
    $file = $_FILES['video'];

    // ตรวจสอบว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
    if($file['error'] === 0) {
      $fileName = $file['name'];
      $fileTmp = $file['tmp_name'];
      $fileType = $file['type'];

      // ตรวจสอบประเภทของไฟล์วิดีโอ
      if($fileType === 'video/mp4' || $fileType === 'video/mov') {
        // กำหนดโฟลเดอร์ที่ต้องการบันทึกไฟล์วิดีโอ
        $uploadPath = 'videos/UploadsVideoNews/' . $fileName;

        // ย้ายไฟล์วิดีโอไปยังโฟลเดอร์ที่กำหนด
        move_uploaded_file($fileTmp, $uploadPath);

        echo "Video imported successfully.";
      } else {
        echo "Invalid video format. Please upload MP4 or MOV video.";
      }
    } else {
      echo "Error uploading video. Please try again.";
    }
  }
  ?>

  <h1>Video Import</h1>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="video" accept="video/mp4,video/mov">
    <br>
    <input type="submit" value="Import">
  </form>
</body>
</html>