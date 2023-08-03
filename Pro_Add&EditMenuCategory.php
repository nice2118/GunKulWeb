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
  $Send_Code = isset($_POST['Send_Code']) ? $_POST['Send_Code'] : 0;
  $Send_Relation = isset($_POST['Send_Relation']) ? $_POST['Send_Relation'] : 0;
  $Send_Text = $_POST['Send_Text'];
  $Send_descriptionth = $_POST['Send_descriptionth'];
  $Send_descriptionen = $_POST['Send_descriptionen'];
  $Type = $_POST['Send_MenuCategoryType'];

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  if ($Send_Code == 0) {
    switch ($Type) {
      case "headingcategories":
        $sql = "INSERT INTO `newsandactivities`.`headingcategories` (`HC_Code`, `HC_Text`, `HC_descriptionth`, `HC_descriptionen`, `HC_CreateDate`, `HC_ModifyDate`) VALUES (NULL, '$Send_Text', '$Send_descriptionth', '$Send_descriptionen', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        break;
      case "headinggroup":
          
          break;
      case "heading":
          
          break;
      case "details":
          
          break;
      default:
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
          $_SESSION['StatusAlert'] = "error";
          break;
    }
  } else {    
    switch ($heading_category_Type) {
      case "headingcategories":
          $sql = "UPDATE `newsandactivities`.`headingcategories` SET  `HC_Text` = '$Send_Text', `HC_descriptionth` = '$Send_descriptionth', `HC_descriptionen` = '$Send_descriptionen',`HC_ModifyDate` = CURRENT_TIMESTAMP WHERE `headingcategories`.`HC_Code` = $Send_Code;";
          break;
      case "headinggroup":
          
          break;
      case "heading":
          
          break;
      case "details":
          
          break;
      default:
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการอัพเดชข้อมูล";
          $_SESSION['StatusAlert'] = "error";
          break;
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