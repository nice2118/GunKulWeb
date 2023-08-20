<?php
include("DB_Include.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับตัวกรองที่ส่งมาจาก JavaScript
    $pmCode = $_POST["pmcode"];
    $pmType = $_POST["pmtype"];

    if ($pmType === 'menu') {
        $sql = "SELECT * FROM `permissionmenu` WHERE `PM_Menu` = $pmCode;";
    } elseif ($pmType === 'submenu'){
        $sql = "SELECT * FROM `permissionmenu` WHERE `PM_RelationPermission` = $pmCode;";
    } else {
        exit;
    }

    $result = $conn->query($sql);
    $dataFromDB = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $typeLower = strtolower($row["PM_RelationType"]);
            $dataFromDBSub = array();
            if ($typeLower === 'category') {
                $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
                $result2 = $conn->query($sql);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $dataFromDBSub[] = array('SubCode' => $row2["CG_Entity No."], 'Subname' => $row2["CG_Name"]);
                    }
                }
            } elseif ($typeLower === 'headingcategories') {
                $sql = "SELECT * FROM `headingcategories`;";
                $result2 = $conn->query($sql);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $dataFromDBSub[] = array('SubCode' => $row2["HC_Code"], 'Subname' => $row2["HC_Text"]);
                    }
                }
            } elseif ($typeLower === 'engravedcategory') {
                $sql = "SELECT * FROM `engravedcategory`;";
                $result2 = $conn->query($sql);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $dataFromDBSub[] = array('SubCode' => $row2["EC_Code"], 'Subname' => $row2["EC_Name"]);
                    }
                }
            } elseif ($typeLower === 'setupgames') {
                
            } elseif ($typeLower === 'setup') {
                
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