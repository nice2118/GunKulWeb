<?php
session_start(); // ต้องเรียกใช้ session_start() ก่อนใช้งาน session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {
    // รับข้อมูลที่ส่งมาจาก Ajax
    $user = $_POST['user'];
    $title = $_POST['title'];
    $message = $_POST['message'];
    $alertType = $_POST['alertType'];

    // ทำตามโลจิกที่ต้องการ เช่นบันทึกลงฐานข้อมูล หรือจัดการข้อมูลในรูปแบบอื่น ๆ
    // ตัวอย่างนี้จะเก็บข้อมูลลง session เป็นตัวอย่าง
    $_SESSION['User'] = $user;
    $_SESSION['StatusTitle'] = $title;
    $_SESSION['StatusMessage'] = $message;
    $_SESSION['StatusAlert'] = $alertType;

    echo "Data received and processed successfully!";
} else {
    echo "Invalid request!";
}
?>