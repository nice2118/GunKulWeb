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
  $EC_Code = isset($_POST['PT_code']) ? $_POST['PT_code'] : 0;
  $PT_name = $_POST['PT_name'];
  $PT_Default = isset($_POST['PT_Default']) ? $_POST['PT_Default'] : 0;
  $PT_Admin = isset($_POST['PT_Admin']) ? $_POST['PT_Admin'] : 0;
  $PT_Manage = isset($_POST['PT_Manage']) ? $_POST['PT_Manage'] : 0;


  if ($EC_Code == 0 || $EC_Code == '') {
      $sql = "INSERT INTO `position` (`PT_Code`, `PT_Name`, `PT_Default`, `PT_Admin`, `PT_Manage`, `PT_CreateDate`, `PT_ModifyDate`) VALUES (NULL, '$PT_name', '$PT_Default', '$PT_Admin', '$PT_Manage', current_timestamp(), current_timestamp());";
  } else {    
      $sql = "UPDATE `position` SET `PT_Name` = '$PT_name', `PT_Default` = '$PT_Default', `PT_Admin` = '$PT_Admin', `PT_Manage` = '$PT_Manage', `PT_ModifyDate` = current_timestamp() WHERE `position`.`PT_Code` = $EC_Code;";
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