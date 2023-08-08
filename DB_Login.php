<?php
include("DB_Include.php");
// ตรวจสอบว่ามีการส่งค่าข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับค่าที่ส่งมาจากฟอร์ม
    $username = $_POST['user'];
    $password = $_POST['password'];

    // ป้องกันการ SQL Injection โดยใช้ prepared statement
    $sql = "SELECT * FROM `user` WHERE `US_Username` = ? AND `US_Password` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    $dataFromDB = array();
    $isValidUser = false;
    $_SESSION['User'] = '';
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['User'] = $row['US_Username'];
        $isValidUser = true;
    }
    
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