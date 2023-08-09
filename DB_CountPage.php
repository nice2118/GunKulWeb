<?php
include("DB_Include.php");
// ตรวจสอบว่ามีการส่งค่าข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับค่าที่ส่งมาจากฟอร์ม
    $Type = $_POST['Type'];
    $Code = $_POST['Code'];
    $PlusNum = 1;

    $TypeLower = strtolower($Type);
    switch ($TypeLower) {
        case "setup":
            $sql = "UPDATE `newsandactivities`.`setup` SET `CountPage` = `CountPage` + $PlusNum WHERE `setup`.`SU_Code` = $Code";
            break;
        case "headingcategories":
            $sql = "UPDATE `newsandactivities`.`headingcategories` SET `CountPage` = `CountPage` + $PlusNum WHERE `headingcategories`.`HC_Code` = $Code";
            break;
        case "activities":
            $sql = "UPDATE `newsandactivities`.`activities` SET `CountPage` = `CountPage` + $PlusNum WHERE  `activities`.`AT_Code` = $Code";
            break;
        case "engravedactivities":
            $sql = "UPDATE `newsandactivities`.`engravedactivities` SET `CountPage` = `CountPage` + $PlusNum WHERE `engravedactivities`.`EC_Code` = $Code";
            break;
        case "fileactivities":
            $sql = "UPDATE `newsandactivities`.`fileactivities` SET `CountPage` = `CountPage` + $PlusNum WHERE `fileactivities`.`FA_Code` = $Code";
            break;
    }
    $isValidUser = false;
    if ($conn->query($sql) === true) {
        $isValidUser = true;
    }
  
    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    
    // เตรียมข้อมูลเพื่อส่งกลับให้กับ Ajax
    $response = array("isValidUser" => $isValidUser);

    // ส่งข้อมูลกลับให้กับ Ajax ในรูปแบบ JSON
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // หากไม่ได้ส่งค่ามาทางฟอร์ม ส่งข้อความคืนกลับให้กับ Ajax เพื่อแสดงข้อความแจ้งเตือน
    $response = array("error" => "Invalid request");
    header("Content-Type: application/json");
    echo json_encode($response);
}
?>