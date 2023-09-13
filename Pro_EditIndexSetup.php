<?php
include("DB_Include.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // เก็บข้อมูลจากฟอร์ม
  $IS_GroupCategory1 = !empty($_POST['IS_GroupCategory1']) ? $_POST['IS_GroupCategory1'] : 0;
  $IS_GroupCategory2 = !empty($_POST['IS_GroupCategory2']) ? $_POST['IS_GroupCategory2'] : 0;
  $IS_GroupCategory3 = !empty($_POST['IS_GroupCategory3']) ? $_POST['IS_GroupCategory3'] : 0;
  $IS_GroupCategory4 = !empty($_POST['IS_GroupCategory4']) ? $_POST['IS_GroupCategory4'] : 0;
  $IS_GroupCategory5 = !empty($_POST['IS_GroupCategory5']) ? $_POST['IS_GroupCategory5'] : 0;
  $IS_GroupCategory6 = !empty($_POST['IS_GroupCategory6']) ? $_POST['IS_GroupCategory6'] : 0;
  $IS_GroupMenu1 = !empty($_POST['IS_GroupMenu1']) ? $_POST['IS_GroupMenu1'] : '';
  $IS_GroupMenu1_Box1 = !empty($_POST['IS_GroupMenu1_Box1']) ? $_POST['IS_GroupMenu1_Box1'] : 0;
  $IS_GroupMenu2 = !empty($_POST['IS_GroupMenu2']) ? $_POST['IS_GroupMenu2'] : '';
  $IS_GroupMenu2_Box2 = !empty($_POST['IS_GroupMenu2_Box2']) ? $_POST['IS_GroupMenu2_Box2'] : 0;
  $IS_GroupMenu3 = !empty($_POST['IS_GroupMenu3']) ? $_POST['IS_GroupMenu3'] : '';
  $IS_GroupMenu3_Box3 = !empty($_POST['IS_GroupMenu3_Box3']) ? $_POST['IS_GroupMenu3_Box3'] : 0;
  $IS_GroupMenu4 = !empty($_POST['IS_GroupMenu4']) ? $_POST['IS_GroupMenu4'] : '';
  $IS_GroupMenu4_Box4 = !empty($_POST['IS_GroupMenu4_Box4']) ? $_POST['IS_GroupMenu4_Box4'] : 0;
  $IS_UserCreate = $globalCurrentUser;

// echo "IS_GroupCategory1: " . $IS_GroupCategory1 . "<br>";
// echo "IS_GroupCategory2: " . $IS_GroupCategory2 . "<br>";
// echo "IS_GroupMenu1: " . $IS_GroupMenu1 . "<br>";
// echo "IS_GroupMenu1_Box1: " . $IS_GroupMenu1_Box1 . "<br>";
// echo "IS_GroupMenu2: " . $IS_GroupMenu2 . "<br>";
// echo "IS_GroupMenu2_Box2: " . $IS_GroupMenu2_Box2 . "<br>";
// echo "IS_GroupMenu3: " . $IS_GroupMenu3 . "<br>";
// echo "IS_GroupMenu3_Box3: " . $IS_GroupMenu3_Box3 . "<br>";
// echo "IS_GroupMenu4: " . $IS_GroupMenu4 . "<br>";
// echo "IS_GroupMenu4_Box4: " . $IS_GroupMenu4_Box4 . "<br>";

  // สร้างคำสั่ง SQL UPDATE
  $sql = "UPDATE `indexsetup` SET
    `IS_GroupCategory1` = '$IS_GroupCategory1',
    `IS_GroupCategory2` = '$IS_GroupCategory2',
    `IS_GroupCategory3` = '$IS_GroupCategory3',
    `IS_GroupCategory4` = '$IS_GroupCategory4',
    `IS_GroupCategory5` = '$IS_GroupCategory5',
    `IS_GroupCategory6` = '$IS_GroupCategory6',
    `IS_GroupMenu1` = '$IS_GroupMenu1',
    `IS_GroupMenu1_Box1` = '$IS_GroupMenu1_Box1',
    `IS_GroupMenu2` = '$IS_GroupMenu2',
    `IS_GroupMenu2_Box2` = '$IS_GroupMenu2_Box2',
    `IS_GroupMenu3` = '$IS_GroupMenu3',
    `IS_GroupMenu3_Box3` = '$IS_GroupMenu3_Box3',
    `IS_GroupMenu4` = '$IS_GroupMenu4',
    `IS_GroupMenu4_Box4` = '$IS_GroupMenu4_Box4',
    `IS_UserCreate` = '$IS_UserCreate',
    `IS_ModifyDate` = CURRENT_TIMESTAMP
  WHERE `indexsetup`.`IS_Code` = 1;";
  if ($conn->query($sql) === true) {
    $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
    $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
    $_SESSION['StatusAlert'] = "success";
  } else {
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = "Error: ".$conn->error;
    $_SESSION['StatusAlert'] = "error";
  }
  // ปิดการเชื่อมต่อฐานข้อมูล
  $conn->close();

  // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
   echo '<script> setTimeout(function() { window.location.href = "./AdminSetup"; }, 0); </script>';
}
?>