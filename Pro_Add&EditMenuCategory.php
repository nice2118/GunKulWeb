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

  // echo '-----'.$Send_Code.'++++'.$Send_Relation.'****'.$Send_Text.'////'.$Type;

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  $TypeLower = strtolower($Type);
  if ($Send_Code == 0 || $Send_Code == '') {
    switch ($TypeLower) {
      case "headingcategories":
        $sql = "INSERT INTO `newsandactivities`.`headingcategories` (`HC_Code`, `HC_Text`, `HC_descriptionth`, `HC_descriptionen`, `HC_UserCreate`, `HC_CreateDate`, `HC_ModifyDate`) VALUES (NULL, '$Send_Text', '$Send_descriptionth', '$Send_descriptionen', '{$_SESSION['User']}', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        // echo 'a';
        break;
      case "headinggroup":
        $sql = "INSERT INTO `newsandactivities`.`headinggroup` (`HG_Code`, `HG_Text`, `HG_Active`, `HC_Code`, `HG_UserCreate`, `HG_CreateDate`, `HG_ModifyDate`) VALUES (NULL, '$Send_Text', '1', '$Send_Relation', '{$_SESSION['User']}', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        // echo 'b';
        $resultMasterHeadingCategories = $conn->query("SELECT * FROM `masterheadingcategories` WHERE `HC_Code` = $Send_Relation ORDER BY `MC_Code` ASC;");
        if ($resultMasterHeadingCategories->num_rows > 0) {
          if ($conn->query($sql) === true) {
              $sql = "";
              $insertedHG_Code = $conn->insert_id;    
              // นำข้อมูลที่ได้จาก headinggroup มาเพิ่มเข้าไปในตาราง heading โดย loop ผ่านทุก row ที่ได้จาก masterheadingcategories
              while ($rowMasterHeadingCategories = $resultMasterHeadingCategories->fetch_assoc()) {
                  $MC_Text = $rowMasterHeadingCategories["MC_Text"];
                  $sql .= "INSERT INTO `newsandactivities`.`heading` (`HD_Code`, `HD_Text`, `HD_Active`, `HG_Code`, `HD_UserCreate`, `HD_CreateDate`, `HD_ModifyDate`) VALUES (NULL, '$MC_Text', '1', '$insertedHG_Code', '{$_SESSION['User']}', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
              }
          } else {
              $_SESSION['StatusTitle'] = "Error!";
              $_SESSION['StatusMessage'] = "Error: ".$conn->error;
              $_SESSION['StatusAlert'] = "error";
              if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                header("Location: ".$_SESSION['PathPage']);
                unset($_SESSION['PathPage']);
              }
          }
        }
        break;
      case "heading":
        $sql = "INSERT INTO `newsandactivities`.`heading` (`HD_Code`, `HD_Text`, `HD_Active`, `HG_Code`, `HD_UserCreate`, `HD_CreateDate`, `HD_ModifyDate`) VALUES (NULL, '$Send_Text', '1', '$Send_Relation', '{$_SESSION['User']}' , CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        // echo 'c';
        break;
      case "details":
        $sql = "INSERT INTO `newsandactivities`.`details` (`DT_Code`, `DT_Text`, `DT_Active`, `HD_Code`,`DT_UserCreate` , `DT_CreateDate`, `DT_ModifyDate`) VALUES (NULL, '$Send_Text', '1', '$Send_Relation', '{$_SESSION['User']}' , CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        // echo 'd';
        break;
      default:
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
          $_SESSION['StatusAlert'] = "error";
          break;
    }
  } else {    
    switch ($TypeLower) {
      case "headingcategories":
          $sql = "UPDATE `newsandactivities`.`headingcategories` SET `HC_Text` = '$Send_Text', `HC_descriptionth` = '$Send_descriptionth', `HC_descriptionen` = '$Send_descriptionen',`HC_ModifyDate` = CURRENT_TIMESTAMP WHERE `headingcategories`.`HC_Code` = $Send_Code;";
          // echo 'aa';
          break;
      case "headinggroup":
          $sql = "UPDATE `newsandactivities`.`headinggroup` SET `HG_Text` = '$Send_Text', `HG_ModifyDate` = CURRENT_TIMESTAMP WHERE `headinggroup`.`HG_Code` = $Send_Code;";
          // echo 'bb';
          break;
      case "heading":
          $sql = "UPDATE `newsandactivities`.`heading` SET `HD_Text` = '$Send_Text', `HD_ModifyDate` = CURRENT_TIMESTAMP WHERE `heading`.`HD_Code` = $Send_Code;";
          // echo 'cc';
          break;
      case "details":
          $sql = "UPDATE `newsandactivities`.`details` SET `DT_Text` = '$Send_Text', `DT_ModifyDate` = CURRENT_TIMESTAMP WHERE `details`.`DT_Code` = $Send_Code;";
          // echo 'dd';
          break;
      default:
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการอัพเดชข้อมูล";
          $_SESSION['StatusAlert'] = "error";
          break;
    }
  }
  if ($conn->multi_query($sql) === true) {
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