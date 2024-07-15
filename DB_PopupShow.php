<?php
    include("DB_Include.php");
    // ตรวจสอบว่ามีการส่งค่าข้อมูลผ่านแบบ POST มาหรือไม่
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // รับค่าที่ส่งมาจากฟอร์ม
        $currentDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['currentDate'])));
        $data = array();

        $sql = "SELECT * FROM `alertpopup` WHERE `alertpopup`.`AP_Active` = 1 AND '$currentDate' BETWEEN `alertpopup`.`AP_DateStart` AND `alertpopup`.`AP_DateEnd` ORDER BY `alertpopup`.`AP_Sort` DESC;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array('id' => $row["AP_Code"], 'name' => $row["AP_Name"], 'image' => 'img/Popup/'.$row["AP_Image"], 'link' => $row["AP_Link"]);
            }
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();

        // ส่งข้อมูลกลับให้กับ Ajax ในรูปแบบ JSON
        header("Content-Type: application/json");
        echo json_encode($data);
    } else {
        // หากไม่ได้ส่งค่ามาทางฟอร์ม ส่งข้อความคืนกลับให้กับ Ajax เพื่อแสดงข้อความแจ้งเตือน
        $response = array("error" => "Invalid request");
        header("Content-Type: application/json");
        echo json_encode($response);
    }
?>