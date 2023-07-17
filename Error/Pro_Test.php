<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // ตรวจสอบว่ามีไฟล์ถูกส่งมาหรือไม่
  if (isset($_FILES['GalleryImage']['name'])) {
    $fileNames = $_FILES['GalleryImage']['name'];

    // ตรวจสอบว่า $fileNames เป็น array หรือไม่
    if (is_array($fileNames)) {
      // วนลูปเพื่อบันทึกไฟล์ที่ถูกส่งมาทั้งหมด
      foreach ($fileNames as $key => $fileName) {
        // ตรวจสอบข้อผิดพลาดในการอัปโหลดไฟล์
        if ($_FILES['GalleryImage']['error'][$key] === UPLOAD_ERR_OK) {
          // ดำเนินการต่อไป...
        } else {
          echo 'AAAAเกิดข้อผิดพลาดในการอัปโหลดไฟล์ ' . $fileName . '<br>';
        }
      }
    } else {
      echo 'BBBBBไม่พบไฟล์ที่ถูกส่งมา<br>';
    }
  } else {
    echo 'CCCCCCไม่พบไฟล์ที่ถูกส่งมา<br>';
  }
}
?>

