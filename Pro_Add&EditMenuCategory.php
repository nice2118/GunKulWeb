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
  $HC_Code = isset($_POST['HC_Code']) ? $_POST['HC_Code'] : 0;
  $HC_Text = $_POST['HC_Text'];
  $HC_descriptionth = $_POST['HC_descriptionth'];
  $HC_descriptionen = $_POST['HC_descriptionen'];

  // echo $HC_Code.'--'.$HC_Text.'++'.$HC_descriptionth.'=='.$HC_descriptionen;

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  if ($HC_Code == 0) {
    $sql = "INSERT INTO `newsandactivities`.`headingcategories` (`HC_Code`, `HC_Text`, `HC_descriptionth`, `HC_descriptionen`, `HC_CreateDate`, `HC_ModifyDate`) VALUES (NULL, '$HC_Text', '$HC_descriptionth', '$HC_descriptionen', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
  } else {    
    $sql = "UPDATE `newsandactivities`.`headingcategories` SET  `HC_Text` = '$HC_Text', `HC_descriptionth` = '$HC_descriptionth', `HC_descriptionen` = '$HC_descriptionen',`HC_ModifyDate` = CURRENT_TIMESTAMP WHERE `headingcategories`.`HC_Code` = $HC_Code;";
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
  echo '<script> setTimeout(function() { window.location.href = "./Ui_AdminSetup.php"; }, 0); </script>';
}

?>
</head>
</html>