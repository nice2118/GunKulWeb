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
    $US_Type = $_POST['US_Type'];
    $US_Prefix = $_POST['US_Prefix'];
    $US_Fname = $_POST['US_Fname'];
    $US_Lname = $_POST['US_Lname'];
    $PT_Code = $_POST['PT_Code'];
    $US_Username = $_POST['US_Username'];
    $US_Password = $_POST['US_Password'];

    $TypeLower = strtolower($US_Type);
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
            $sql = "INSERT INTO `user` (`US_Username`, `US_Password`, `US_Prefix`, `US_Fname`, `US_Lname`, `US_Image`, `US_Active`, `PT_Code`, `US_CreateDate`, `US_ModifyDate`) VALUES ('$US_Username', '$US_Password', '$US_Prefix', '$US_Fname', '$US_Lname', '', '1', '$PT_Code', current_timestamp(), current_timestamp());";
            break;
    
        case "edit":
            $sql = "UPDATE `user` SET `US_Password` = '$US_Password', `US_Prefix` = '$US_Prefix', `US_Fname` = '$US_Fname', `US_Lname` = '$US_Lname', `PT_Code` = '$PT_Code', `US_ModifyDate` = CURRENT_TIMESTAMP WHERE `user`.`US_Username` = '$US_Username';";
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