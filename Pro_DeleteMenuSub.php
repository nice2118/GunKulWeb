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

// สร้างคำสั่ง SQL ในการลบข้อมูลจากตาราง
$sql1 = "DELETE FROM `permissionposition` WHERE `PM_Code` = $MenuSub_id;";
$sql2 = "DELETE FROM `PermissionMenu` WHERE `PM_RelationPermission` IN (SELECT `PM_Code` `PermissionMenu` WHERE `PM_Code` = $MenuSub_id);";
$sql3 = "DELETE FROM `PermissionMenu` WHERE `PM_Code` = $MenuSub_id;";

// ลบข้อมูลและตรวจสอบผลลัพธ์
if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$MenuSub_Name." เรียบร้อยแล้ว";
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
