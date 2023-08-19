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
  $EC_Code = isset($_POST['EC_code']) ? $_POST['EC_code'] : 0;
  $EC_Name = $_POST['EC_name'];
  $EC_descriptionth = $_POST['EC_descriptionth'];
  $EC_descriptionen = $_POST['EC_descriptionen'];


  if ($EC_Code == 0 || $EC_Code == '') {
      $sql = "INSERT INTO `engravedcategory` (`EC_Code`, `EC_Name`, `EC_DescriptionTH`, `EC_DescriptionEN`, `EC_UserCreate`, `EC_CreateDate`, `EC_ModifyDate`) VALUES (NULL, '$EC_Name', '$EC_descriptionth', '$EC_descriptionen', '{$_SESSION['User']}', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
  } else {    
      $sql = "UPDATE `engravedcategory` SET `EC_Name` = '$EC_Name', `EC_DescriptionTH` = '$EC_descriptionth', `EC_DescriptionEN` = '$EC_descriptionen', `EC_ModifyDate` = CURRENT_TIMESTAMP WHERE `engravedcategory`.`EC_Code` = $EC_Code;";
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