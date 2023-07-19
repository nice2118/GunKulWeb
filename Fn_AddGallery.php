<?php
/// ฟังก์ชันเพิ่มรูปลงGallery
function generateGallery($fileArray,$idActivities) {
    global $conn;
    
    // เช็คว่ามีไฟล์ถูกส่งมาหรือไม่
    if (isset($fileArray['name'])) {
      $fileCount = count($fileArray['name']);
  
      // วนลูปเพื่ออัปโหลดและเพิ่มข้อมูลลงในฐานข้อมูล
      for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $fileArray['name'][$i];
        $fileTmp = $fileArray['tmp_name'][$i];
        $fileType = $fileArray['type'][$i];
        
        // สร้างชื่อไฟล์ใหม่
        $newFileName = generateNewFileName($fileName);
        $destination = 'img/UploadAddGallery/' . $newFileName;
        
        // บันทึกไฟล์
        move_uploaded_file($fileTmp, $destination);
        
        // เพิ่มข้อมูลลงในฐานข้อมูล
        $query = "INSERT INTO `newsandactivities`.`gallery` (`GR_Entity No.`, `GR_Activities Code`, `GR_Name`, `GR_CreateDate`, `GR_ModifyDate`) VALUES (NULL, '$idActivities', '$newFileName', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        if ($conn->query($query) !== true) {
          echo "Error: " . $query . "<br>" . $conn->error;
        }
      }
      // echo 'อัปโหลดไฟล์เรียบร้อยแล้ว';
    } else {
      echo 'ไม่พบไฟล์ที่ถูกส่งมา';
    }
  }
  
  // ฟังก์ชันสร้างชื่อไฟล์ใหม่โดยใช้ Primary Key
  function generateNewFileName($fileName) {
    global $conn;
    $query = 'SELECT MAX(`GR_Entity No.`) AS max_id FROM Gallery';
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $maxId = $row['max_id'];
    } else {
      $maxId = 0;
    } 
    $newFileName = $maxId + 1 . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
    $result->close();
    return $newFileName;
  }
?>