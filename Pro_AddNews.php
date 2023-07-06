<?php
include("DB_Include.php");
include("DB_Setup.php");

echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // เก็บข้อมูลจากฟอร์ม
  $DateAddNews = $_POST['DateAddNews'];
  $DateAddNewsFormatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateAddNews)));
  $Title = $_POST['Title'];
  $Summary = $_POST['Summary'];
  $Summernote = $_POST['summernote'];

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
      $sql = "SELECT MAX(NA_Code) AS maxCode FROM news";
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
      header("Location: ".$_SESSION['PathPage']);
    }
  } else {
    // echo 'An error occurred while uploading the file.'; // เกิดข้อผิดพลาดในการอัปโหลดไฟล์
  }

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  $sql = "INSERT INTO `news` (`NA_Code`, `NA_Date`, `NA_Time`, `NA_Title`, `NA_Description`, `NA_Note`, `NA_Image`, `NA_CreateDate`, `NA_ModifyDate`) VALUES (NULL, '$DateAddNewsFormatted', CURRENT_TIME(), '$Title', '$Summary', '$Summernote', '$newnFullNameImage', CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
  // ดำเนินการ INSERT ข้อมูล
  if ($conn->query($sql) === true) {
    // $_SESSION['StatusMessage'] = 'กรุณากลับไป Setup ก่อน';
    //     header("Location: ".$_SESSION['PathPage']);
    //     exit();
    // echo '<script>swal("Success.");</script>';
    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการบันทึกในหัวข้อ ".$Title." เรียบร้อบแล้ว";
    $_SESSION['StatusAlert'] = "success";
  } else {
    if (!empty($newnFullNameImage)) {
      $filePath = $PathFolderNews . $newnFullNameImage;

      if (file_exists($filePath)) {
          if (unlink($filePath)) {
              // echo 'File deleted successfully.';
          } else {
              $_SESSION['StatusTitle'] = "Error!";
              $_SESSION['StatusMessage'] = "Unable to delete the file.";
              $_SESSION['StatusAlert'] = "error";
              header("Location: ".$_SESSION['PathPage']);
          }
      } else {
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "File not found.";
          $_SESSION['StatusAlert'] = "error";
          header("Location: ".$_SESSION['PathPage']);
      }
  }
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = "Error: ".$conn->error;
    $_SESSION['StatusAlert'] = "error";
    header("Location: ".$_SESSION['PathPage']);
  }

  // ปิดการเชื่อมต่อฐานข้อมูล
  $conn->close();

  // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
  // echo "<meta http-equiv=\"refresh\" content=\"0; url=./News_ListAdmin.php\">";
  echo '<script> setTimeout(function() { window.location.href = "./News_ListAdmin.php"; }, 0); </script>';
}
?>

