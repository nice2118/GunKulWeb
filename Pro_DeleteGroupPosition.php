<?php
include("DB_Include.php");
    if (isset($_GET['Send_ID']) && $_GET['Send_ID'] !== '') {
        $Send_ID = $_GET['Send_ID'];
        $Send_Name = $_GET['Send_Name'];
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
        $sql1 = "DELETE FROM `grouppositionline` WHERE `GH_Code` IN (SELECT `GH_Code` FROM `grouppositionheader` WHERE `GH_Code` = $Send_ID)";
        $conn->query($sql1);

        // ส่งคำสั่ง SQL เพื่อลบข้อมูลในตาราง `heading` ที่ตรงกับ `HD_Code` ในตาราง `headinggroup`
        $sql2 = "DELETE FROM `grouppositionheader` WHERE `GH_Code` = $Send_ID";
        $conn->query($sql2);
    
        // หากไม่มีข้อผิดพลาดในการลบข้อมูลในตารางทั้งหมด จะทำการยืนยันการลบข้อมูล
        $conn->commit();
    
        $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
        $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ " . $Send_Name . " เรียบร้อบแล้ว";
        $_SESSION['StatusAlert'] = "success";
    } catch (Exception $e) {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการลบข้อมูล";
        $_SESSION['StatusAlert'] = "error";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    echo "<script>setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
?>