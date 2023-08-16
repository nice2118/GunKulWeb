<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $type = $_POST['type'];

    $data = array();

    $typeLower = strtolower($type);

    if ($typeLower === 'category') {
        $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
        $result = $conn->query($sql);
        $dataFromDB = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array('id' => $row["CG_Entity No."], 'name' => $row["CG_Name"]);
            }
        }
    } elseif ($typeLower === 'headingcategories') {
        $sql = "SELECT * FROM `headingcategories`;";
        $result = $conn->query($sql);
        $dataFromDB = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array('id' => $row["HC_Code"], 'name' => $row["HC_Text"]);
            }
        }
    } elseif ($typeLower === 'engravedcategory') {
        $sql = "SELECT * FROM `engravedcategory`;";
        $result = $conn->query($sql);
        $dataFromDB = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array('id' => $row["EC_Code"], 'name' => $row["EC_Name"]);
            }
        }
    } elseif ($typeLower === 'detupgames') {

    } elseif ($typeLower === 'setup') {

    } elseif ($typeLower === 'NoType') {

    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อมูลที่ได้กลับไปให้ JavaScript ในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>