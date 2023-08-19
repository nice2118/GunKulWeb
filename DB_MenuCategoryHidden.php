<?php
include("DB_Include.php");
// เช็คว่ามีการส่งค่า status, variable1, และ variable2 มาหรือไม่
if (isset($_POST['status']) && isset($_POST['type']) && isset($_POST['id'])) {
    $status = $_POST['status'];
    $type = $_POST['type'];
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

    // ตรวจสอบค่าใน $type ว่าเป็น headinggroup, heading, หรือ details เท่านั้น
    if ($type != 'headinggroup' && $type != 'heading' && $type != 'details') {
        $response = array(
            'error' => 'Invalid type value ='.$type
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // ตรวจสอบค่าใน $id ว่าเป็นตัวเลขเท่านั้น
    if (!is_numeric($id)) {
        $response = array(
            'error' => 'Invalid id value'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    $TypeLower = strtolower($type);
    switch ($TypeLower) {
        case "headinggroup":
            $sql1 = "UPDATE `headinggroup` SET `HG_Active` = '$status' WHERE `headinggroup`.`HG_Code` = $id;";
            $conn->query($sql1);
            break;
        case "heading":
            $sql1 = "UPDATE `heading` SET `HD_Active` = '$status' WHERE `heading`.`HD_Code` = $id;";
            $conn->query($sql1);
            break;
        case "details":
            $sql1 = "UPDATE `details` SET `DT_Active` = '$status' WHERE `details`.`DT_Code` = $id;";
            $conn->query($sql1);
            break;
    }

    $conn->commit();
    $response = array(
        'status' => $status,
        'type' => $type,
        'id' => $id
    );
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
