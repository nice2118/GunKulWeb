<?php
if (isset($_FILES["ImageGallery"]["name"])) {
  $fileCount = count($_FILES["ImageGallery"]["name"]);
  echo $fileCount;
} else {
  echo "ไม่พบไฟล์ที่ถูกส่งมา";
}
?>