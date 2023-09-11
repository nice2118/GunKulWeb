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
    $Profile_Image = $_POST['Profile_Image'];
    $Profile_UsernameOld = $_POST['Profile_UsernameOld'];
    $Profile_PasswordOld = $_POST['Profile_PasswordOld'];
    $Profile_Prefix = $_POST['Profile_Prefix'];
    $Profile_Fname = $_POST['Profile_Fname'];
    $Profile_Lname = $_POST['Profile_Lname'];
    $Profile_Username = $_POST['Profile_Username'];
    $Profile_Password = $_POST['Profile_Password'];
    $Profile_ConfirmPassword = $_POST['Profile_ConfirmPassword'];

    $FullNameImage = '';
    if (isset($_FILES['Profile_imageUser']) && $_FILES['Profile_imageUser']['error'] === UPLOAD_ERR_OK) {
        $Send_OldImage = isset($_POST['Profile_Image']) ? $_POST['Profile_Image'] : '';
        $PathFolderUser = 'img/User/';

        $file = $_FILES['Profile_imageUser'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
    
        // ตรวจสอบว่าเป็นไฟล์รูปภาพหรือไม่
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            $newnNameImage = $Profile_Username;
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

    $sql = "UPDATE `user` SET `US_Username` = '$Profile_Username', `US_Prefix` = '$Profile_Prefix', `US_Fname` = '$Profile_Fname', `US_Lname` = '$Profile_Lname'";
    if ($Profile_PasswordOld != '') {
        $sqlCheckLogin = "SELECT * FROM `user` WHERE `US_Username` = ? AND `US_Password` = ?";
        $stmt = $conn->prepare($sqlCheckLogin);
        $stmt->bind_param("ss", $Profile_UsernameOld, $Profile_PasswordOld);
        $stmt->execute();
        $resultCheckLogin = $stmt->get_result();
        
        if ($resultCheckLogin->num_rows > 0) {
            $rowCheckLogin = $resultCheckLogin->fetch_assoc();
            if ($Profile_UsernameOld === $rowCheckLogin['US_Username'] && $Profile_PasswordOld === $rowCheckLogin['US_Password']){
                if ($Profile_Password != $Profile_ConfirmPassword) {
                    $_SESSION['StatusTitle'] = "Error!";
                    $_SESSION['StatusMessage'] = "เนื่องจากกรอกช่อง Password กับ Confirm Password ไม่ตรงกัน";
                    $_SESSION['StatusAlert'] = "error";
                    if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                        header("Location: ".$_SESSION['PathPage']);
                        unset($_SESSION['PathPage']);
                    }
                    exit;
                } else {
                    if ($Profile_Password != ''){
                        $sql .= ", `US_Password` = '$Profile_Password'";
                    } else {
                        $_SESSION['StatusTitle'] = "Error!";
                        $_SESSION['StatusMessage'] = "กรุณาใส่รหัสใหม่";
                        $_SESSION['StatusAlert'] = "error";
                        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                            header("Location: ".$_SESSION['PathPage']);
                            unset($_SESSION['PathPage']);
                        }
                        exit;
                    }
                }
            } else {
                $_SESSION['StatusTitle'] = "Error!";
                $_SESSION['StatusMessage'] = "รหัสเก่าไม่ตรงกับของเดิม";
                $_SESSION['StatusAlert'] = "error";
                if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                    header("Location: ".$_SESSION['PathPage']);
                    unset($_SESSION['PathPage']);
                }
                exit;
            }
        } else {
            $_SESSION['StatusTitle'] = "Error!";
            $_SESSION['StatusMessage'] = "เนื่องจาก Old Password ไม่ถูกต้อง";
            $_SESSION['StatusAlert'] = "error";
            if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                header("Location: ".$_SESSION['PathPage']);
                unset($_SESSION['PathPage']);
            }
            exit;
        }
    }
    if ($FullNameImage !== '') {
        $sql .= ", `US_Image` = '$FullNameImage'";
    } 
    $sql .= ", `US_ModifyDate` = CURRENT_TIMESTAMP WHERE `user`.`US_Username` = '$Profile_UsernameOld';";

    if ($Profile_UsernameOld != $Profile_Username){
        $sqlSetPosition = "SELECT * FROM `setposition` WHERE `setposition`.`US_Username` = '$Profile_UsernameOld';";
        $resultSetPosition = $conn->query($sqlSetPosition);
        if ($resultSetPosition->num_rows > 0) {
            while ($rowSetPosition = $resultSetPosition->fetch_assoc()) {
                $sqlUpdateSetPosition = "UPDATE `setposition` SET `US_Username` = '$Profile_Username', `SP_ModifyDate` = CURRENT_TIMESTAMP WHERE `setposition`.`SP_Code` = '{$rowSetPosition["SP_Code"]}';";
                if ($conn->query($sqlUpdateSetPosition) === true) {
                    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
                    $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
                    $_SESSION['StatusAlert'] = "success";
                } else {
                    $_SESSION['StatusTitle'] = "Error!";
                    $_SESSION['StatusMessage'] = "Error: Update setposition";
                    $_SESSION['StatusAlert'] = "error";
                }
            }
        }
    }

    if ($conn->query($sql) === true) {
        $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
        $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
        $_SESSION['StatusAlert'] = "success";
        $_SESSION['User'] = $Profile_Username;
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