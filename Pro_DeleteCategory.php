<?php
include("DB_Include.php");
if (isset($_GET['Send_ID']) && $_GET['Send_ID'] !== '') {
    $t_id = $_GET['Send_ID'];
    $t_Name = $_GET['Send_Name'];
  } else {
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = 'ไม่พบเลขที่เอกสารนี้';
    $_SESSION['StatusAlert'] = "error";
    if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
      header("Location: ".$_SESSION['PathPage']);
      unset($_SESSION['PathPage']);
    }
    exit();
  }

echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
$sql = "DELETE FROM `category` WHERE `category`.`CG_Entity No.` = $t_id";
if ($conn->query($sql) === true) {
  // $_SESSION['StatusMessage'] = 'กรุณากลับไป Setup ก่อน';
  //     header("Location: ".$_SESSION['PathPage']);
  //     exit();
  $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
  $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$t_Name." เรียบร้อบแล้ว";
  $_SESSION['StatusAlert'] = "success";
} else {
  $_SESSION['StatusTitle'] = "Error!";
  $_SESSION['StatusMessage'] = "Cannot be deleted = ".$t_id;
  $_SESSION['StatusAlert'] = "error";
}
echo '<script> setTimeout(function() { window.location.href = "./Ui_AdminSetup.php"; }, 0); </script>';
?>

