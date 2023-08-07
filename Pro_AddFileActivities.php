<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GUNKUL Engineering (GUNKUL)</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
<?php
include("DB_Include.php");
include("DB_Setup.php");

echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // เก็บข้อมูลจากฟอร์ม
  // $ID = $_POST['ID'];
  $CategoryBegin_id = $_POST['CategoryBegin_id'];
  $CategoryID = $_POST['Send_Category'];
  $DateAdd = $_POST['DateAdd'];
  $DateAddFormatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateAdd)));
  $Title = $_POST['Title'];
  $Summary = $_POST['Summary'];

  // เก็บข้อมูลไฟล์
  $file = $_FILES['file'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];

  // เช็คว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
  if ($fileError === UPLOAD_ERR_OK) {
    // เช็คประเภทไฟล์
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'];

    if (in_array($fileType, $allowedExtensions)) {
      // ย้ายไฟล์ไปยังตำแหน่งที่ต้องการ (เช่นโฟลเดอร์ uploads)
      $sql = "SHOW TABLE STATUS LIKE 'fileactivities'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $maxCode = $row['Auto_increment'];
          if (!empty($maxCode)) {
              $newnNameFile = $maxCode;
          } else {
              $newnNameFile = 1;
          }
      } else {
          $newnNameFile = 1;
      }
      // $newnNameFile++;
      $newnFullNameFile = $newnNameFile.'.'.$fileType;
      unset($sql);

      $destination = $PathDefaultFile . $newnFullNameFile;
      if (!file_exists($PathDefaultFile)) {
        mkdir($PathDefaultFile, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
      }
      move_uploaded_file($fileTmpName, $destination);
      // echo 'The file has been uploaded successfully. Its name is: ' . $newnFullNameFile; // ไฟล์ถูกอัปโหลดเรียบร้อยแล้วชื่อว่า
    } else {
      $_SESSION['StatusTitle'] = "Error!"; // รูปแบบไฟล์ไม่ถูกต้อง
      $_SESSION['StatusMessage'] = "Invalid file format.";
      $_SESSION['StatusAlert'] = "error";
      if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
        header("Location: ".$_SESSION['PathPage']);
        unset($_SESSION['PathPage']);
      }
    }
  } else {
    // echo 'An error occurred while uploading the file.'; // เกิดข้อผิดพลาดในการอัปโหลดไฟล์
  }

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  $sql = "INSERT INTO `newsandactivities`.`fileactivities` (`FA_Code`, `FA_Entity No.`, `FA_UserCreate`, `FA_Date`, `FA_Time`, `FA_Title`, `FA_Description`, `FA_File`, `FA_CreateDate`, `FA_ModifyDate`) VALUES (NULL, $CategoryID, '', '$DateAddFormatted', CURRENT_TIME(), '$Title', '$Summary', '$newnFullNameFile', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());";
  // ดำเนินการ INSERT ข้อมูล
  if ($conn->query($sql) === true) {
    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการบันทึกในหัวข้อ ".$Title." เรียบร้อบแล้ว";
    $_SESSION['StatusAlert'] = "success";
  } else {
    if (!empty($newnFullNameFile)) {
      $filePath = $PathDefaultFile . $newnFullNameFile;

      if (file_exists($filePath)) {
          if (unlink($filePath)) {
              // echo 'File deleted successfully.';
          } else {
              $_SESSION['StatusTitle'] = "Error!";
              $_SESSION['StatusMessage'] = "Unable to delete the file.";
              $_SESSION['StatusAlert'] = "error";
              if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                header("Location: ".$_SESSION['PathPage']);
                unset($_SESSION['PathPage']);
              }
          }
      } else {
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "File not found.";
          $_SESSION['StatusAlert'] = "error";
          if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
            header("Location: ".$_SESSION['PathPage']);
            unset($_SESSION['PathPage']);
        }
      }
    }
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = "Error: ".$conn->error;
    $_SESSION['StatusAlert'] = "error";
    if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
      header("Location: ".$_SESSION['PathPage']);
      unset($_SESSION['PathPage']);
    }
  }

  // ปิดการเชื่อมต่อฐานข้อมูล
  $conn->close();

  // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
  echo '<script> setTimeout(function() { window.location.href = "./Ui_ListAdmin.php?Send_Category=' . $CategoryBegin_id . '"; }, 0); </script>';
}
?>
</head>
</html>