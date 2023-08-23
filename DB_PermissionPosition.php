<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $sendpmcode = $_POST["sendpmcode"];

    $sql = "SELECT * FROM `permissionposition` WHERE `PM_Code` = $sendpmcode;";

    $result = $conn->query($sql);
    $dataFromDB = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $typeLower = strtolower($row["PP_Type"]);
            $dataFromDBSub = array();
            if ($typeLower === 'single') {
                $sql2 = "SELECT * FROM `position`;";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $dataFromDBSub[] = array('id' => $row2["PT_Code"], 'name' => $row2["PT_Name"]);
                    }
                }
            } elseif ($typeLower === 'multi') {
                $sql2 = "SELECT * FROM `grouppositionheader`;";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $dataFromDBSub[] = array('id' => $row2["GH_Code"], 'name' => $row2["GH_Name"]);
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