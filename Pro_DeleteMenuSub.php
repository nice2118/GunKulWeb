<?php
include("DB_Include.php");

if (isset($_GET['Send_ID']) && $_GET['Send_ID'] !== '') {
    $MenuSub_id = $_GET['Send_ID'];
    $MenuSub_Name = $_GET['Send_Name'];
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

$sql1 = "DELETE FROM `newsandactivities`.`PermissionMenu` WHERE `PermissionMenu`.`PM_Code` = $MenuSub_id;";
$conn->query($sql1);

if ($conn->query($sql1) === TRUE) {
  $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
  $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$MenuSub_Name." เรียบร้อบแล้ว";
  $_SESSION['StatusAlert'] = "success";
} else {
  $_SESSION['StatusTitle'] = "Error!";
  $_SESSION['StatusMessage'] = "Cannot be deleted = ".$MenuSub_id;
  $_SESSION['StatusAlert'] = "error";
}


    // หากไม่มีข้อผิดพลาดในการลบข้อมูลในตารางทั้งหมด จะทำการยืนยันการลบข้อมูล
    $conn->commit();

    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ " . $MenuSub_Name . " เรียบร้อบแล้ว";
    $_SESSION['StatusAlert'] = "success";

echo "<script>setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";

exit();
?>