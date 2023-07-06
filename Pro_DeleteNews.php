<?php
include("DB_Include.php");
if (isset($_GET['Send_IDNews']) && $_GET['Send_IDNews'] !== '') {
    $t_id = $_GET['Send_IDNews'];
    $t_Title = $_GET['Send_Title'];
  } else {
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = 'ไม่พบเลขที่เอกสารนี้';
    $_SESSION['StatusAlert'] = "error";
    header("Location: ".$_SESSION['PathPage']);
    unset($_SESSION['PathPage']);
    exit();
  }

echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
$sql = "DELETE FROM `news` WHERE `news`.`NA_Code` = $t_id";
if ($conn->query($sql) === true) {
  // $_SESSION['StatusMessage'] = 'กรุณากลับไป Setup ก่อน';
  //     header("Location: ".$_SESSION['PathPage']);
  //     exit();
  $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
  $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$t_Title." เรียบร้อบแล้ว";
  $_SESSION['StatusAlert'] = "success";
} else {
  $_SESSION['StatusTitle'] = "Error!";
  $_SESSION['StatusMessage'] = "Cannot be deleted = ".$t_id;
  $_SESSION['StatusAlert'] = "error";
}
echo '<script> setTimeout(function() { window.location.href = "./News_ListAdmin.php"; }, 0); </script>';
?>

