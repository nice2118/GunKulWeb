<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $ecCode = $_POST["eccode"];

    $sql = "SELECT * FROM `engravedactivities` WHERE `EC_Code` = $ecCode;";
    $result = $conn->query($sql);
    $dataFromDB = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataFromDB[] = $row;
        }
    }
    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อมูลที่ได้กลับไปให้ JavaScript ในรูปแบบ JSON
    header("Content-Type: application/json");
    echo json_encode($dataFromDB);
}
?>