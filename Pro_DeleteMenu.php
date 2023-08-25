<?php
include("DB_Include.php");

  if (isset($_GET['Send_ID']) && $_GET['Send_ID'] !== '') {
      $Menu_id = $_GET['Send_ID'];
      $Menu_Name = $_GET['Send_Name'];
  } else {
      $_SESSION['StatusTitle'] = "Error!";
      $_SESSION['StatusMessage'] = 'ไม่พบเลขที่เอกสารนี้';
      $_SESSION['StatusAlert'] = "error";
      if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
          header("Location: " . $_SESSION['PathPage']);
          unset($_SESSION['PathPage']);
      }
      exit();
  }

  // สร้างคำสั่ง SQL ในการลบข้อมูลจากตาราง
  $sql1 = "DELETE FROM `permissionposition` WHERE `PM_Code` IN (SELECT `PM_Code` FROM `PermissionMenu` WHERE `PM_Menu` IN (SELECT `MN_Code` FROM `Menu` WHERE `MN_Code` = $Menu_id));";
  $sql2 = "DELETE FROM `PermissionMenu` WHERE `PM_RelationPermission` IN (SELECT `PM_Code` FROM `PermissionMenu` WHERE `PM_Menu` IN (SELECT `MN_Code` FROM `Menu` WHERE `MN_Code` = $Menu_id));";
  $sql3 = "DELETE FROM `PermissionMenu` WHERE `PM_Menu` IN (SELECT `MN_Code` FROM `Menu` WHERE `MN_Code` = $Menu_id);";
  $sql4 = "DELETE FROM `Menu` WHERE `MN_Code` = $Menu_id;";

  // ลบข้อมูลตามลำดับ และตรวจสอบผลลัพธ์
  if ($conn->query($sql1) && $conn->query($sql2) && $conn->query($sql3) && $conn->query($sql4)) {
      $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
      $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$Menu_Name." เรียบร้อยแล้ว";
      $_SESSION['StatusAlert'] = "success";
  } else {
      $_SESSION['StatusTitle'] = "Error!";
      $_SESSION['StatusMessage'] = "Cannot be deleted = ".$Menu_id;
      $_SESSION['StatusAlert'] = "error";
  }

  // หากไม่มีข้อผิดพลาดในการลบข้อมูลในตารางทั้งหมด จะทำการยืนยันการลบข้อมูล
  $conn->commit();

  $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
  $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ " . $Menu_Name . " เรียบร้อบแล้ว";
  $_SESSION['StatusAlert'] = "success";

  echo "<script>setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";

  exit();
?>
