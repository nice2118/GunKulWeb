<?php
include("DB_Include.php");

if (isset($_GET['Send_ID']) && $_GET['Send_ID'] !== '') {
    $Position_id = $_GET['Send_ID'];
    $Position_Name = $_GET['Send_Name'];
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

$sql1 = "DELETE FROM `position` WHERE `position`.`PT_Code` = $Position_id;";
$conn->query($sql1);

if ($conn->query($sql1) === TRUE) {
  $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
  $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$Position_Name." เรียบร้อบแล้ว";
  $_SESSION['StatusAlert'] = "success";
} else {
  $_SESSION['StatusTitle'] = "Error!";
  $_SESSION['StatusMessage'] = "Cannot be deleted = ".$Position_id;
  $_SESSION['StatusAlert'] = "error";
}

echo "<script>setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";

exit();
?>
