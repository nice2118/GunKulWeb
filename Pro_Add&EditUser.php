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
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // เก็บข้อมูลจากฟอร์ม
    $US_Type = $_POST['US_Type'];
    $US_Prefix = $_POST['US_Prefix'];
    $US_Fname = $_POST['US_Fname'];
    $US_Lname = $_POST['US_Lname'];
    // $PT_Code = $_POST['PT_Code'];
    $PT_Code = '0';
    $US_Username = $_POST['US_Username'];
    $Old_US_Username = isset($_POST['US_UsernameOld']) ? $_POST['US_UsernameOld'] : '';
    $US_Password = $_POST['US_Password'];
    $US_Password = $_POST['US_Password'];

    $TypeLower = strtolower($US_Type);

    $FullNameImage = '';
    if (isset($_FILES['imageUser']) && $_FILES['imageUser']['error'] === UPLOAD_ERR_OK) {
        $Send_OldImage = isset($_POST['US_Image']) ? $_POST['US_Image'] : '';
        $PathFolderUser = 'img/User/';

        $file = $_FILES['imageUser'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
    
        // ตรวจสอบว่าเป็นไฟล์รูปภาพหรือไม่
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            $newnNameImage = $US_Username;
            $FullNameImage = $newnNameImage.'.'.$fileExtension;
    
            if ($Send_OldImage != ''){
                $filePath = $PathFolderUser . $Send_OldImage;
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                    }
                }
            }
    
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
          exit;
        }
    }

    switch ($TypeLower) {
        case "add":
            $sql = "SELECT * FROM `user` WHERE `user`.`US_Username` = '$US_Username';";
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
            $sql = "INSERT INTO `user` (`US_Username`, `US_Password`, `US_Prefix`, `US_Fname`, `US_Lname`, `US_Image`, `US_Active`, `PT_Code`, `US_CreateDate`, `US_ModifyDate`) VALUES ('$US_Username', '$US_Password', '$US_Prefix', '$US_Fname', '$US_Lname', '$FullNameImage', '1', '$PT_Code', current_timestamp(), current_timestamp());";
            
            $sqlPosition = "SELECT * FROM `position` WHERE `position`.`PT_Default` = '1';";
            $resultPosition = $conn->query($sqlPosition);
            if ($resultPosition->num_rows > 0) {
                while ($rowPosition = $resultPosition->fetch_assoc()) {
                    $sqlDefaultSetPosition = "INSERT INTO `setposition` (`SP_Code`, `US_Username`, `PT_Code`, `SP_CreateDate`, `SP_ModifyDate`) VALUES (NULL,'$US_Username', '{$rowPosition["PT_Code"]}', current_timestamp(), current_timestamp());";
                    if ($conn->query($sqlDefaultSetPosition) === true) {
                        $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
                        $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
                        $_SESSION['StatusAlert'] = "success";
                    } else {
                        $_SESSION['StatusTitle'] = "Error!";
                        $_SESSION['StatusMessage'] = "Error: Add setposition";
                        $_SESSION['StatusAlert'] = "error";
                        exit;
                    }
                }
            }
            break;
    
        case "edit":
            if ($FullNameImage == '') {
                $sql = "UPDATE `user` SET `US_Username` = '$US_Username', `US_Password` = '$US_Password', `US_Prefix` = '$US_Prefix', `US_Fname` = '$US_Fname', `US_Lname` = '$US_Lname', `PT_Code` = '$PT_Code', `US_ModifyDate` = CURRENT_TIMESTAMP WHERE `user`.`US_Username` = '$Old_US_Username';";
            } else {
                $sql = "UPDATE `user` SET `US_Username` = '$US_Username', `US_Password` = '$US_Password', `US_Prefix` = '$US_Prefix', `US_Fname` = '$US_Fname', `US_Lname` = '$US_Lname', `PT_Code` = '$PT_Code', `US_Image` = '$FullNameImage', `US_ModifyDate` = CURRENT_TIMESTAMP WHERE `user`.`US_Username` = '$Old_US_Username';";
            }
            if ($Old_US_Username != $US_Username){
                $sqlSetPosition = "SELECT * FROM `setposition` WHERE `setposition`.`US_Username` = '$Old_US_Username';";
                $resultSetPosition = $conn->query($sqlSetPosition);
                if ($resultSetPosition->num_rows > 0) {
                    while ($rowSetPosition = $resultSetPosition->fetch_assoc()) {
                        $sqlUpdateSetPosition = "UPDATE `setposition` SET `US_Username` = '$US_Username', `SP_ModifyDate` = CURRENT_TIMESTAMP WHERE `setposition`.`SP_Code` = '{$rowSetPosition["SP_Code"]}';";
                        if ($conn->query($sqlUpdateSetPosition) === true) {
                            $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
                            $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
                            $_SESSION['StatusAlert'] = "success";
                        } else {
                            $_SESSION['StatusTitle'] = "Error!";
                            $_SESSION['StatusMessage'] = "Error: Update setposition";
                            $_SESSION['StatusAlert'] = "error";
                            exit;
                        }
                    }
                }
            }
            break;
    
        default:
            $_SESSION['StatusTitle'] = "Error!";
            $_SESSION['StatusMessage'] = "ค่า Type ไม่ถูกต้อง";
            $_SESSION['StatusAlert'] = "error";
            if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                header("Location: ".$_SESSION['PathPage']);
                unset($_SESSION['PathPage']);
            }
            exit;
            break;
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