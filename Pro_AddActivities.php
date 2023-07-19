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
include("Fn_AddGallery.php");

echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // เก็บข้อมูลจากฟอร์ม
  $CategoryBegin_id = $_POST['CategoryBegin_id'];
  $CategoryID = $_POST['Send_Category'];
  $DateAddNews = $_POST['DateAddNews'];
  $DateAddNewsFormatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateAddNews)));
  $Title = $_POST['Title'];
  $Summary = $_POST['Summary'];
  $Summernote = base64_encode($_POST['summernote']);
  // $Summernote = $_POST['summernote'];

  // เก็บข้อมูลไฟล์
  $file = $_FILES['image'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];

  $newnFullNameImage = $DefaultImageNews;

  // เช็คว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
  if ($fileError === UPLOAD_ERR_OK) {
    // เช็คประเภทไฟล์
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedExtensions)) {
      // ย้ายไฟล์ไปยังตำแหน่งที่ต้องการ (เช่นโฟลเดอร์ uploads)
      $sql = "SELECT MAX(AT_Code) AS maxCode FROM Activities";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $maxCode = $row['maxCode'];

          if (!empty($maxCode)) {
              $newnNameImage = $maxCode;
          } else {
              $newnNameImage = 1;
          }
      } else {
          $newnNameImage = 1;
      }
      $newnNameImage++;
      $newnFullNameImage = $newnNameImage.'.'.$fileType;
      unset($sql);

      $destination = $PathFolderNews . $newnFullNameImage;
      if (!file_exists($PathFolderNews)) {
        mkdir($PathFolderNews, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
      }
      move_uploaded_file($fileTmpName, $destination);
      // echo 'The file has been uploaded successfully. Its name is: ' . $newnFullNameImage; // ไฟล์ถูกอัปโหลดเรียบร้อยแล้วชื่อว่า
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
  $sql = "INSERT INTO `Activities` (`AT_Code`, `AT_Entity No.`, `AT_Date`, `AT_Time`, `AT_Title`, `AT_Description`, `AT_Note`, `AT_Image`, `AT_CreateDate`, `AT_ModifyDate`) VALUES (NULL, $CategoryID, '$DateAddNewsFormatted', CURRENT_TIME(), '$Title', '$Summary', '$Summernote', '$newnFullNameImage', CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
  // ดำเนินการ INSERT ข้อมูล
  if ($conn->query($sql) === true) {
    // $_SESSION['StatusMessage'] = 'กรุณากลับไป Setup ก่อน';
    //     header("Location: ".$_SESSION['PathPage']);
    //     exit();
    // echo '<script>swal("Success.");</script>';
    $lastInsertID = $conn->insert_id;
    // echo $lastInsertID;
    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการบันทึกในหัวข้อ ".$Title." เรียบร้อบแล้ว";
    $_SESSION['StatusAlert'] = "success";
    generateGallery($_FILES['ImageGallery'],$lastInsertID);
  } else {
    if (!empty($newnFullNameImage) && $newnFullNameImage !== $DefaultImageNews) {
      $filePath = $PathFolderNews . $newnFullNameImage;

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
  // echo "<meta http-equiv=\"refresh\" content=\"0; url=./Ui_ListAdmin.php\">";
  echo '<script> setTimeout(function() { window.location.href = "./Ui_ListAdmin.php?Send_Category=' . $CategoryBegin_id . '"; }, 0); </script>';
}
?>
</head>
</html>