<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $sendghcode = $_POST["sendghcode"];
    $dataFromDB = array();
        $sql = "SELECT * FROM `position`;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataFromDBSub = array();
                if ($sendghcode != 0){
                    $sql = "SELECT * FROM `grouppositionline` WHERE `grouppositionline`.`GH_Code` = $sendghcode AND `PT_Code` ='{$row["PT_Code"]}';";
                    $result2 = $conn->query($sql);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $dataFromDBSub[] = array('PT_Code' => $row2["PT_Code"]);
                        }
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