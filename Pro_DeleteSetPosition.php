<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $sendspcode = $_POST["Send_ID"];

    $sql = "DELETE FROM `setposition` WHERE `setposition`.`SP_Code` = $sendspcode;";
    if ($conn->query($sql) === true) {
        $response = true;
    } else {
        $response = false;
    }
    // $response = true;

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อมูลที่ได้กลับไปให้ JavaScript ในรูปแบบ JSON
    header("Content-Type: application/json");
    echo json_encode($response);
}
?>