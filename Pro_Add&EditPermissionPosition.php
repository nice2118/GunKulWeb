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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['PP_Code'])) {
        // เก็บข้อมูลจากฟอร์ม
        $Send_PM_Code = $_POST['Send_PM_Code'];
        // Array
        $PP_Code = $_POST['PP_Code'];
        $PP_Type = $_POST['PP_Type'];
        $PP_PT_Code = $_POST['PP_PT_Code'];

        for ($i = 0; $i < count($PP_Code); $i++) {
            if ($PP_Code[$i] == 0 || $PP_Code[$i] == '') {
                $sql = "INSERT INTO `permissionposition` (`PP_Code`, `PP_Type`, `PT_Code`, `PM_Code`, `PP_CreateDate`, `PP_ModifyDate`) VALUES (NULL, '$PP_Type[$i]', '$PP_PT_Code[$i]', '$Send_PM_Code', current_timestamp(), current_timestamp());";
            } else {    
                $sql = "UPDATE `permissionposition` SET `PP_Type` = '$PP_Type[$i]', `PT_Code` = '$PP_PT_Code[$i]', `PM_Code` = '$Send_PM_Code', `PP_ModifyDate` = current_timestamp() WHERE `permissionposition`.`PP_Code` = $PP_Code[$i];";
            }
            if ($conn->query($sql) === true) {
                $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
                $_SESSION['StatusMessage'] = "ทำการบันทึกเรียบร้อบแล้ว";
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
        }
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
    echo "<script> setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
}
?>
</head>
</html>