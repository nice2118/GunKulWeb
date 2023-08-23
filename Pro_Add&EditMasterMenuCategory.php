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
        // ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาจากฟอร์มหรือไม่
        if (isset($_POST['mcinputname'])) {
            // รับข้อมูลจากฟอร์ม
            $inputMastercode = $_POST['inputMastercode'];
            $inputcode = $_POST['mcinputcode'];
            $inputNames = $_POST['mcinputname'];
            // ตัวอย่างการประมวลผลข้อมูลที่ได้รับมาจากฟอร์ม
            for ($i = 0; $i < count($inputNames); $i++) {
                if ($inputNames[$i] != '') {
                    if ($inputcode[$i] == 0 || $inputcode[$i] == '') {
                        $sql = "INSERT INTO `masterheadingcategories` (`MC_Code`, `MC_Text`, `HC_Code`, `MC_UserCreate`, `MC_CreateDate`, `MC_ModifyDate`) VALUES (Null, '$inputNames[$i]', '$inputMastercode', '{$_SESSION['User']}', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
                    } else {    
                        $sql = "UPDATE `masterheadingcategories` SET `MC_Text` = '$inputNames[$i]' WHERE `masterheadingcategories`.`MC_Code` = $inputcode[$i];";
                    }
                    if ($conn->query($sql) === true) {
                        $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
                        $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
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
        }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
      echo "<script> setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
    }
?>
</head>
</html>