<?php
include("DB_Include.php");

if (isset($_GET['Send_ID']) && $_GET['Send_ID'] !== '') {
    $User_id = $_GET['Send_ID'];
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

$sql = "DELETE FROM `user` WHERE `user`.`US_Username` = '$User_id';";

if ($conn->query($sql) === TRUE) {
  $Send_OldImage = isset($_POST['Send_Img']) ? $_POST['Send_Img'] : '';
  $PathFolderUser = 'img/User/';
  if ($Send_OldImage != ''){
      $filePath = $PathFolderUser . $Send_OldImage;
      if (file_exists($filePath)) {
          if (unlink($filePath)) {
          }
      }
  }
  $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
  $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$User_id." เรียบร้อบแล้ว";
  $_SESSION['StatusAlert'] = "success";
} else {
  $_SESSION['StatusTitle'] = "Error!";
  $_SESSION['StatusMessage'] = "Cannot be deleted = ".$User_id;
  $_SESSION['StatusAlert'] = "error";
}

echo "<script>setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";

exit();
?>
