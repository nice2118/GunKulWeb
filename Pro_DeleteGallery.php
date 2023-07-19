<?php
include("DB_Include.php");
// รับค่า ID ที่ส่งมาจาก JavaScript
$imageID = $_POST['imageID'];

// สร้างคำสั่ง SQL สำหรับลบข้อมูลที่มี ID ที่รับมา
$sql = "DELETE FROM `Gallery` WHERE `GR_Entity No.` = '$imageID'";

if ($conn->query($sql) === TRUE) {
    echo 'success';
} else {
    echo 'error';
}
$conn->close();
?>

