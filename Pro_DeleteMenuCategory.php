<?php
include("DB_Include.php");

if (isset($_GET['Send_ID']) && $_GET['Send_ID'] !== '') {
    $heading_category_id = $_GET['Send_ID'];
    $heading_category_Text = $_GET['Send_Text'];
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

// เริ่มต้นเปิด transaction
$conn->autocommit(false);

try {
    // ส่งคำสั่ง SQL เพื่อลบข้อมูลในตาราง `details` ที่ตรงกับ `HD_Code` ในตาราง `heading`
    $sql1 = "DELETE FROM `details` WHERE `HD_Code` IN (SELECT `HD_Code` FROM `heading` WHERE `HG_Code` IN (SELECT `HG_Code` FROM `headinggroup` WHERE `HC_Code` = $heading_category_id))";
    $conn->query($sql1);

    // ส่งคำสั่ง SQL เพื่อลบข้อมูลในตาราง `heading` ที่ตรงกับ `HG_Code` ในตาราง `headinggroup`
    $sql2 = "DELETE FROM `heading` WHERE `HG_Code` IN (SELECT `HG_Code` FROM `headinggroup` WHERE `HC_Code` = $heading_category_id)";
    $conn->query($sql2);

    // ส่งคำสั่ง SQL เพื่อลบข้อมูลในตาราง `headinggroup` ที่ตรงกับ `HC_Code` ในตาราง `headingcategories`
    $sql3 = "DELETE FROM `headinggroup` WHERE `HC_Code` = $heading_category_id";
    $conn->query($sql3);

    // ส่งคำสั่ง SQL เพื่อลบข้อมูลในตาราง `headingcategories` ที่ตรงกับ `HC_Code`
    $sql4 = "DELETE FROM `headingcategories` WHERE `HC_Code` = $heading_category_id";
    $conn->query($sql4);

    // หากไม่มีข้อผิดพลาดในการลบข้อมูลในตารางทั้งหมด จะทำการยืนยันการลบข้อมูล
    $conn->commit();

    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ " . $heading_category_Text . " เรียบร้อบแล้ว";
    $_SESSION['StatusAlert'] = "success";
} catch (Exception $e) {
    // หากเกิดข้อผิดพลาดในการลบข้อมูลในตาราง จะทำการยกเลิกการลบข้อมูลทั้งหมดและทำการ rollback
    $conn->rollback();

    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการลบข้อมูล";
    $_SESSION['StatusAlert'] = "error";
}

echo '<script> setTimeout(function() { window.location.href = "./Ui_AdminSetup.php"; }, 0); </script>';
exit();
?>
