<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $sendptCode = $_POST["sendptCode"];

    $sql = "SELECT * FROM `user`;";
    $result = $conn->query($sql);
    $dataFromDB = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataFromDBSub = array();
            $sql = "SELECT * FROM `setposition` WHERE `setposition`.`US_Username` = '{$row["US_Username"]}' AND `PT_Code` ='$sendptCode';";
                $result2 = $conn->query($sql);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $dataFromDBSub[] = array('setpositioncode' => $row2["US_Username"]);
                    }
                }
            $row["dataFromDBSub"] = $dataFromDBSub;
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