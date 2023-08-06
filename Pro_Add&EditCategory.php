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
  $CG_EntityNo = isset($_POST['CG_EntityNo']) ? $_POST['CG_EntityNo'] : 0;
  $CG_EntityRelationNo = isset($_POST['CG_EntityRelationNo']) ? $_POST['CG_EntityRelationNo'] : 0;  
  $CG_Name = $_POST['CG_Name'];
  $CG_DescriptionTH = $_POST['CG_DescriptionTH'];
  $CG_DescriptionEN = $_POST['CG_DescriptionEN'];
  // echo $CG_EntityNo.'--'.$CG_EntityRelationNo.'++'.$CG_Name.'//'.$CG_DescriptionTH.'=='.$CG_DescriptionEN;

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  if ($CG_EntityNo == 0 || $CG_EntityNo == '') {
    $sql = "INSERT INTO `newsandactivities`.`category` (`CG_Entity No.`, `CG_Entity Relation No.`, `CG_Name`, `CG_DescriptionTH`, `CG_DescriptionEN`, `CG_CreateDate`, `CG_ModifyDate`) VALUES (NULL, $CG_EntityRelationNo, '$CG_Name', '$CG_DescriptionTH', '$CG_DescriptionEN', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
  } else {    
    $sqlCheck = "SELECT * FROM `category` WHERE `category`.`CG_Name` = $CG_Name;";
    $resultCheck = $conn->query($sqlCheck);
    if ($resultCheck->num_rows > 0) {
      $rowCheck = $resultCheck->fetch_assoc();
      if ($rowCheck["CG_Entity No."] == $CG_EntityRelationNo) {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = "เนื่องจากต้องไม่สามารถเลือกในลำดับชั้นของตัวเองได้";
        $_SESSION['StatusAlert'] = "error";
        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
          header("Location: ".$_SESSION['PathPage']);
          unset($_SESSION['PathPage']);
          exit;
        }
      }
    }
    $sql = "UPDATE `newsandactivities`.`category` SET `CG_Entity Relation No.` = $CG_EntityRelationNo , `CG_Name` = '$CG_Name', `CG_DescriptionTH` = '$CG_DescriptionTH', `CG_DescriptionEN` = '$CG_DescriptionEN',`CG_ModifyDate` = CURRENT_TIMESTAMP WHERE `category`.`CG_Entity No.` = $CG_EntityNo;";
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