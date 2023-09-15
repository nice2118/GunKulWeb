<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GUNKUL Intranet</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
<?php
include("DB_Include.php");

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // เก็บข้อมูลจากฟอร์ม
    $AP_Code = isset($_POST['AP_Code']) ? $_POST['AP_Code'] : 0;
    $AP_Name = $_POST['AP_Name'];
    $AP_DateStart = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['AP_DateStart'])));
    $AP_DateEnd = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['AP_DateEnd'])));

    $FullNameImage = '';
    if (isset($_FILES['imagePopup']) && $_FILES['imagePopup']['error'] === UPLOAD_ERR_OK) {
        $Send_OldImage = isset($_POST['AP_OldImage']) ? $_POST['AP_OldImage'] : '';
        $PathFolderPopup = 'img/Popup/';

        $file = $_FILES['imagePopup'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
    
        // ตรวจสอบว่าเป็นไฟล์รูปภาพหรือไม่
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            if ($AP_Code == 0 || $AP_Code == '') {
                $sql = "SHOW TABLE STATUS LIKE 'alertpopup'";
                $result = $conn->query($sql);
          
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $maxCode = $row['Auto_increment'];
          
                    if (!empty($maxCode)) {
                        $newNameImage = $maxCode;
                    } else {
                        $newNameImage = 1;
                    }
                } else {
                    $newNameImage = 1;
                }
            } else {
                $newNameImage = $AP_Code;
            }
            $FullNameImage = $newNameImage.'.'.$fileExtension;
    
            if ($Send_OldImage != ''){
                $filePath = $PathFolderPopup . $Send_OldImage;
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                    }
                }
            }
    
          $destination = $PathFolderPopup . $FullNameImage;
          if (!file_exists($PathFolderPopup)) {
            mkdir($PathFolderPopup, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
          }
          move_uploaded_file($fileTmpName, $destination);
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
    }

    if ($AP_Code == 0 || $AP_Code == '') {
        $sql = "INSERT INTO `alertpopup` (`AP_Code`, `AP_Name`, `AP_Image`, `AP_DateStart`, `AP_DateEnd`, `AP_UserCreate`, `AP_Active`, `AP_CreateDate`, `AP_ModifyDate`) VALUES (NULL, '$AP_Name', '$FullNameImage', '$AP_DateStart', '$AP_DateEnd', '$globalCurrentUser', '1', current_timestamp(), current_timestamp());";
    } else {    
        if ($FullNameImage == '') {
            $sql = "UPDATE `alertpopup` SET `AP_Name` = '$AP_Name', `AP_DateStart` = '$AP_DateStart', `AP_DateEnd` = '$AP_DateEnd', `AP_ModifyDate` = current_timestamp() WHERE `alertpopup`.`AP_Code` = '$AP_Code';";
        } else {
            $sql = "UPDATE `alertpopup` SET `AP_Name` = '$AP_Name', `AP_Image` = '$FullNameImage', `AP_DateStart` = '$AP_DateStart', `AP_DateEnd` = '$AP_DateEnd', `AP_ModifyDate` = current_timestamp() WHERE `alertpopup`.`AP_Code` = '$AP_Code';";
        }
    }

    if ($conn->query($sql) === true) {
        $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
        $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
        $_SESSION['StatusAlert'] = "success";
    } else {
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
  echo "<script> setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
}
?>
</head>
</html>