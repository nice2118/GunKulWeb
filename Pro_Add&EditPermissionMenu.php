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
    // เก็บข้อมูลจากฟอร์ม
    $MN_CodeSub = $_POST['MN_CodeSub'];
    $PM_Type = $_POST['PM_Type'];
    // Array
    $PM_Code = $_POST['PM_Code'];
    $PM_Name = $_POST['PM_Name'];
    $PM_RelationType = $_POST['PM_RelationType'];
    $PM_RelationCode = $_POST['PM_RelationCode'];
    $PM_Direction = $_POST['PM_Direction'];
    $PM_Draw = $_POST['PM_Draw'];
    $PM_Setup = $_POST['PM_Setup'];
    $typeLower = strtolower($PM_Type);

    for ($i = 0; $i < count($PM_Code); $i++) {
        if ($PM_Code[$i] == 0 || $PM_Code[$i] == '') {
            if ($typeLower === 'menu') {
                $sql = "INSERT INTO `permissionmenu` (`PM_Code`, `PM_RelationPermission`, `PM_Menu`, `PM_RelationType`, `PM_RelationCode`, `PM_Name`, `PM_Direction`, `PM_draw`, `PM_Setup`, `PM_UserCreate`, `PM_CreateDate`, `PM_ModifyDate`) VALUES (NULL, '0', '$MN_CodeSub', '$PM_RelationType[$i]', '$PM_RelationCode[$i]', '$PM_Name[$i]', '$PM_Direction[$i]', '$PM_Draw[$i]', '$PM_Setup[$i]', '{$_SESSION['User']}', current_timestamp(), current_timestamp());";
            } elseif ($typeLower === 'submenu') {
                $sql = "INSERT INTO `permissionmenu` (`PM_Code`, `PM_RelationPermission`, `PM_Menu`, `PM_RelationType`, `PM_RelationCode`, `PM_Name`, `PM_Direction`, `PM_draw`, `PM_Setup`, `PM_UserCreate`, `PM_CreateDate`, `PM_ModifyDate`) VALUES (NULL, '$MN_CodeSub', '0', '$PM_RelationType[$i]', '$PM_RelationCode[$i]', '$PM_Name[$i]', '$PM_Direction[$i]', '$PM_Draw[$i]', '$PM_Setup[$i]', '{$_SESSION['User']}', current_timestamp(), current_timestamp());";
            }
        } else {    
            $sql = "UPDATE `permissionmenu` SET `PM_RelationType` = '$PM_RelationType[$i]', `PM_RelationCode` = '$PM_RelationCode[$i]', `PM_Name` = '$PM_Name[$i]', `PM_Direction` = '$PM_Direction[$i]', `PM_Draw` = '$PM_Draw[$i]', `PM_Setup` = '$PM_Setup[$i]', `PM_UserCreate` = '{$_SESSION['User']}', `PM_ModifyDate` = current_timestamp() WHERE `permissionmenu`.`PM_Code` = $PM_Code[$i];";
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

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
    echo "<script> setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
}
?>
</head>
</html>