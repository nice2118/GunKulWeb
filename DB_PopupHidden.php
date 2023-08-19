<?php
include("DB_Include.php");
// เช็คว่ามีการส่งค่า status, variable1, และ variable2 มาหรือไม่
if (isset($_POST['status']) && isset($_POST['id'])) {
    $status = $_POST['status'];
    $id = $_POST['id'];

    // ตรวจสอบค่าใน $status ว่าเป็น 0 หรือ 1 เท่านั้น
    if ($status != 0 && $status != 1) {
        $response = array(
            'error' => 'Invalid status value'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // ตรวจสอบค่าใน $id ว่าเป็นตัวเลขเท่านั้น
    if (empty($id)) {
        $response = array(
            'error' => 'Invalid id value'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    $sql = "UPDATE `alertpopup` SET `AP_Active` = '$status' WHERE `alertpopup`.`AP_Code` = '$id';";
    if ($conn->query($sql) === true) {
        $response = array(
            'status' => $status,
            'id' => $id
        );
    } else {
        $response = array(
            'error' => 'can not update'
        );
    }
    // แปลงข้อมูลเป็น JSON และส่งค่ากลับไปยัง JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // หากไม่มีการส่งค่ามาครบถ้วน ให้ส่งข้อความ error กลับไปยัง JavaScript
    $response = array(
        'error' => 'Invalid data'
    );
    // แปลงข้อมูลเป็น JSON และส่งค่ากลับไปยัง JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
