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
  $ID = $_POST['ID'];
  $CategoryBegin_id = $_POST['CategoryBegin_id'];
  $CategoryID = $_POST['Send_Category'];
  $DateAddNews = $_POST['DateAddNews'];
  $DateAddNewsFormatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateAddNews)));
  $Title = $_POST['Title'];
  $Summary = $_POST['Summary'];
  $OldNameFile = $_POST['fileNameInput'];
  

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

    $filePath = $PathDefaultFile . $OldNameFile;

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
            exit;
        }
    } else {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = "File not found.";
        $_SESSION['StatusAlert'] = "error";
        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
          header("Location: ".$_SESSION['PathPage']);
          unset($_SESSION['PathPage']);
        }
        exit;
    }

    if (in_array($fileType, $allowedExtensions)) {
      $OldNameFile = $ID.'.'.$fileType;
      // ย้ายไฟล์ไปยังตำแหน่งที่ต้องการ (เช่นโฟลเดอร์ uploads)
      $destination = $PathDefaultFile . $OldNameFile;
      if (!file_exists($PathDefaultFile)) {
        mkdir($PathDefaultFile, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
      }
      move_uploaded_file($fileTmpName, $destination);
      // echo 'The file has been uploaded successfully. Its name is: ' . $OldNameFile; // ไฟล์ถูกอัปโหลดเรียบร้อยแล้วชื่อว่า
    } else {
      $_SESSION['StatusTitle'] = "Error!"; // รูปแบบไฟล์ไม่ถูกต้อง
      $_SESSION['StatusMessage'] = "Invalid file format.";
      $_SESSION['StatusAlert'] = "error";
      if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
        header("Location: ".$_SESSION['PathPage']);
        unset($_SESSION['PathPage']);
      }
      exit;
    }
  } else {
    // echo 'An error occurred while uploading the file.'; // เกิดข้อผิดพลาดในการอัปโหลดไฟล์
    $OldNameFile = '';
  }

  // echo $OldNameFile;

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  $Title = mysqli_real_escape_string($conn, $Title);
  $Summary = mysqli_real_escape_string($conn, $Summary);
  $sql = "UPDATE `fileactivities` SET `FA_Title` = '$Title', `FA_Description` = '$Summary', `FA_ModifyDate` = CURRENT_TIMESTAMP";
  if (!empty($OldNameFile) && $OldNameFile !== '') {
    $sql .= ", `FA_File` = '$OldNameFile'";
  } 
  $sql .=" WHERE `fileactivities`.`FA_Code` = $ID;";
  // ดำเนินการ INSERT ข้อมูล
  if ($conn->query($sql) === true) {
    // $_SESSION['StatusMessage'] = 'กรุณากลับไป Setup ก่อน';
    //     header("Location: ".$_SESSION['PathPage']);
    //     exit();
    // echo '<script>swal("Success.");</script>';
    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการแก้เอกสารให้หัวข้อ ".$Title." เรียบร้อบแล้ว";
    $_SESSION['StatusAlert'] = "success";
  } else {
    if (!empty($OldNameFile)) {
      $filePath = $PathDefaultFile . $OldNameFile;

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
              exit;
          }
      } else {
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "File not found.";
          $_SESSION['StatusAlert'] = "error";
          if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
            header("Location: ".$_SESSION['PathPage']);
            unset($_SESSION['PathPage']);
          }
          exit;
      }
    }
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = "Error: ".$conn->error;
    $_SESSION['StatusAlert'] = "error";
    if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
      header("Location: ".$_SESSION['PathPage']);
      unset($_SESSION['PathPage']);
    }
    exit;
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