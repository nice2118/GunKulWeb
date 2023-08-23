<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $type = $_POST['type'];

    $data = array();

    $typeLower = strtolower($type);

    if ($typeLower === 'single') {
        $sql = "SELECT * FROM `position`;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array('id' => $row["PT_Code"], 'name' => $row["PT_Name"]);
            }
        }
    } elseif ($typeLower === 'multi') {
        $sql = "SELECT * FROM `grouppositionheader`;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array('id' => $row["GH_Code"], 'name' => $row["GH_Name"]);
            }
        }
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อมูลที่ได้กลับไปให้ JavaScript ในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>