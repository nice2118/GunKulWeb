<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $sendppcode = $_POST["Send_ID"];

    $sql = "DELETE FROM `permissionposition` WHERE `permissionposition`.`PP_Code` = $sendppcode;";
    if ($conn->query($sql) === true) {
        $response = true;
    } else {
        $response = false;
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อมูลที่ได้กลับไปให้ JavaScript ในรูปแบบ JSON
    header("Content-Type: application/json");
    echo json_encode($response);
}
?>