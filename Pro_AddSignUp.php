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
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // เก็บข้อมูลจากฟอร์ม
    $SignUp_Prefix = $_POST['SignUp_Prefix'];
    $SignUp_Fname = $_POST['SignUp_Fname'];
    $SignUp_Lname = $_POST['SignUp_Lname'];
    $SignUp_Username = $_POST['SignUp_Username'];
    $SignUp_Password = $_POST['SignUp_Password'];

    $FullNameImage = '';
    if (isset($_FILES['SignUp_imageUser']) && $_FILES['SignUp_imageUser']['error'] === UPLOAD_ERR_OK) {
        $PathFolderUser = 'img/User/';

        $file = $_FILES['SignUp_imageUser'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
    
        // ตรวจสอบว่าเป็นไฟล์รูปภาพหรือไม่
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            $newnNameImage = $SignUp_Username;
            $FullNameImage = $newnNameImage.'.'.$fileExtension;
    
          $destination = $PathFolderUser . $FullNameImage;
          if (!file_exists($PathFolderUser)) {
            mkdir($PathFolderUser, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
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
        }
    }


    $sql = "SELECT * FROM `user` WHERE `user`.`US_Username` = '$SignUp_Username';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = "เนื่องจากมีผู้ใช้นี้อยู่แล้ว";
        $_SESSION['StatusAlert'] = "error";
        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
            header("Location: ".$_SESSION['PathPage']);
            unset($_SESSION['PathPage']);
        }
        exit;
    }
    $sql = "INSERT INTO `user` (`US_Username`, `US_Password`, `US_Prefix`, `US_Fname`, `US_Lname`, `US_Image`, `US_Active`, `US_CreateDate`, `US_ModifyDate`) VALUES ('$SignUp_Username', '$SignUp_Password', '$SignUp_Prefix', '$SignUp_Fname', '$SignUp_Lname', '$FullNameImage', '1', current_timestamp(), current_timestamp());";
    
    $sqlPosition = "SELECT * FROM `position` WHERE `position`.`PT_Default` = '1';";
    $resultPosition = $conn->query($sqlPosition);
    if ($resultPosition->num_rows > 0) {
        while ($rowPosition = $resultPosition->fetch_assoc()) {
            $sqlDefaultSetPosition = "INSERT INTO `setposition` (`SP_Code`, `US_Username`, `PT_Code`, `SP_CreateDate`, `SP_ModifyDate`) VALUES (NULL,'$SignUp_Username', '{$rowPosition["PT_Code"]}', current_timestamp(), current_timestamp());";
            if ($conn->query($sqlDefaultSetPosition) === true) {
                $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
                $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
                $_SESSION['StatusAlert'] = "success";
            } else {
                $_SESSION['StatusTitle'] = "Error!";
                $_SESSION['StatusMessage'] = "Error: Add setposition";
                $_SESSION['StatusAlert'] = "error";
            }
        }
    }

    if ($conn->query($sql) === true) {
        $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
        $_SESSION['StatusMessage'] = "ทำการสร้างรหัสผู้ใช้งานเรียบร้อยแล้ว";
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