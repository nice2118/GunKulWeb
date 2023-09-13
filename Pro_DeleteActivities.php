<?php
include("DB_Include.php");
if (isset($_GET['Send_IDNews']) && $_GET['Send_IDNews'] !== '') {
    $t_id = $_GET['Send_IDNews'];
    $t_Title = $_GET['Send_Title'];
    $CategoryID = $_GET['Send_Category'];
  } else {
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = 'ไม่พบเลขที่เอกสารนี้';
    $_SESSION['StatusAlert'] = "error";
    if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
      header("Location: ".$_SESSION['PathPage']);
      unset($_SESSION['PathPage']);
    }
    exit();
  }

$sql = "SELECT * FROM `Gallery` LEFT JOIN `Setup` ON `Setup`.`SU_Code` = '1' WHERE `Gallery`.`GR_Activities Code` = '$t_id';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $destination = $row["SU_PathDefaultImageGallery"] . $row["GR_Name"];
    if (file_exists($destination)) { if (unlink($destination)) { } }
  }
}

$sql = "DELETE FROM `Activities` WHERE `Activities`.`AT_Code` = $t_id;";
$sql2 = "DELETE FROM `gallery` WHERE `gallery`.`GR_Activities Code` = $t_id;";
$conn->query($sql2);

if ($conn->query($sql) === true) {
  $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
  $_SESSION['StatusMessage'] = "ทำการลบเอกสารให้หัวข้อ ".$t_Title." เรียบร้อบแล้ว";
  $_SESSION['StatusAlert'] = "success";
} else {
  $_SESSION['StatusTitle'] = "Error!";
  $_SESSION['StatusMessage'] = "Cannot be deleted = ".$t_id;
  $_SESSION['StatusAlert'] = "error";
}
echo '<script> setTimeout(function() { window.location.href = "./ListAdmin?Send_Category=' . $CategoryID . '"; }, 0); </script>';
?>

