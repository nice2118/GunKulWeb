<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GUNKUL Intranet</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
<?php
include("DB_Include.php");
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

    // เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาจากฟอร์มหรือไม่
        if (isset($_POST['inputname']) && isset($_POST['inputvalue'])) {
            // รับข้อมูลจากฟอร์ม
            $inputMastercode = $_POST['inputMastercode'];
            $inputcode = $_POST['inputcode'];
            $inputNames = $_POST['inputname'];
            $inputValues = $_POST['inputvalue'];
            if (isset($_FILES['inputvaluefile'])) {
                $inputFiles = $_FILES['inputvaluefile'];
            } else {
                $inputFiles ='';
            }

            // ตัวอย่างการประมวลผลข้อมูลที่ได้รับมาจากฟอร์ม
            for ($i = 0; $i < count($inputNames); $i++) {
                if ($inputNames[$i] != '' && $inputValues[$i] != '') {
                    if ($inputcode[$i] == 0 || $inputcode[$i] == '') {
                        $sql = "INSERT INTO `engravedactivities` (`EA_Code`, `EC_Code`, `EA_Name`, `EA_Path`, `EC_UserCreate`, `EA_CreateDate`, `EA_ModifyDate`) VALUES (NULL, '$inputMastercode', '$inputNames[$i]', '$inputValues[$i]', '$globalCurrentUser', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
                    } else {    
                        $sql = "UPDATE `engravedactivities` SET `EA_Name` = '$inputNames[$i]', `EA_Path` = '$inputValues[$i]', `EA_ModifyDate` = CURRENT_TIMESTAMP WHERE `engravedactivities`.`EA_Code` = $inputcode[$i];";
                    }
                    if ($conn->query($sql) === true) {
                        if (isset($inputFiles['tmp_name'][$i])) {
                            $fileType = strtolower(pathinfo($inputFiles['name'][$i], PATHINFO_EXTENSION));
                            $allowedTypes = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx');
                        
                            if (in_array($fileType, $allowedTypes)) {
                                // ตรวจสอบว่ามีโฟลเดอร์เป้าหมายอยู่หรือไม่ หากไม่มีให้สร้าง
                                if (!file_exists($inputValues[$i])) {
                                    mkdir($inputValues[$i], 0777, true);
                                }
                        
                                // สร้างชื่อไฟล์ใหม่เพื่อเก็บในโฟลเดอร์เป้าหมาย
                                $fileName = uniqid() . '.' . $fileType;
                                $destination = $inputValues[$i] . '/' . $fileName;
                        
                                // ย้ายไฟล์ไปยังโฟลเดอร์เป้าหมาย
                                move_uploaded_file($inputFiles['tmp_name'][$i], $destination);
                            }
                        }
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