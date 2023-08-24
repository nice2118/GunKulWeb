<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ทำการ logout โดยล้าง session หรือทำตามวิธีที่คุณใช้ในการจัดการ session
    session_start();
    session_destroy();
    session_start();
    $_SESSION['User'] = '';

    // เตรียมข้อมูลเพื่อส่งกลับให้กับ AJAX
    $response = array("success" => true);

    // ส่งข้อมูลกลับให้กับ AJAX ในรูปแบบ JSON
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // หากไม่ได้ส่งค่ามาทาง POST ส่งข้อความคืนกลับให้กับ AJAX เพื่อแสดงข้อความแจ้งเตือน
    $response = array("error" => "Invalid request");
    header("Content-Type: application/json");
    echo json_encode($response);
}
?>