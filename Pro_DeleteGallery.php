<?php
include("DB_Include.php");
// รับค่า ID ที่ส่งมาจาก JavaScript
$imageID = $_POST['imageID'];
$source = $_POST['source'];

$sql = "SELECT * FROM `Gallery` LEFT JOIN `Setup` ON `Setup`.`SU_Code` = '1' WHERE `Gallery`.`GR_Entity No.` = '$imageID';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // $destination = $row["SU_PathDefaultImageGallery"] . $imageID . "/" . $row["GR_Name"];
    $destination = $source;
    if (file_exists($destination)) { if (unlink($destination)) { } }
}

// สร้างคำสั่ง SQL สำหรับลบข้อมูลที่มี ID ที่รับมา
$sql = "DELETE FROM `Gallery` WHERE `GR_Entity No.` = '$imageID'";
if ($conn->query($sql) === TRUE) {
    echo 'success';
} else {
    echo 'error';
}
$conn->close();
?>

