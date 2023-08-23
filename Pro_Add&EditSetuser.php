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
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // เก็บข้อมูลจากฟอร์ม
    $PT_Code = $_POST['Setuser_PT_Code'];
    // Array
    $US_Username = isset($_POST['Setuser_US_Username']) ? $_POST['Setuser_US_Username'] : array();

    // ลบข้อมูลที่ซ้ำออกจากอาร์เรย์
    // $unique_US_Username= array_unique($US_Username);

    // echo "PT_Code: $PT_Code<br>";
    // echo "US_Username: ";
    print_r($US_Username);

    // ลบข้อมูลเดิม
    $sqlDelete = "DELETE FROM `setposition` WHERE `setposition`.`PT_Code` = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $PT_Code);
    $stmtDelete->execute();
    $stmtDelete->close();

    // เพิ่มข้อมูลใหม่
    $sqlInsert = "INSERT INTO `setposition` (`SP_Code`, `SP_Name`, `US_Username`, `PT_Code`, `SP_CreateDate`, `SP_ModifyDate`) VALUES (NULL, '', ?, ?, current_timestamp(), current_timestamp())";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ss", $US_UsernameValue, $PT_Code);

    for ($i = 0; $i < count($US_Username); $i++) {
        $US_UsernameValue = $US_Username[$i];
        $stmtInsert->execute();
    }

    if ($stmtInsert) {
        $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
        $_SESSION['StatusMessage'] = "ทำการอัพเดตเรียบร้อยแล้ว";
        $_SESSION['StatusAlert'] = "success";
    } else {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = "Error: " . $stmtInsert->error;
        $_SESSION['StatusAlert'] = "error";
        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
            header("Location: " . $_SESSION['PathPage']);
            unset($_SESSION['PathPage']);
        }
    }

    $stmtInsert->close();
    $conn->close();

  // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
//   echo "<script> setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
}
?>
</head>
</html>