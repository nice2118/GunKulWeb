<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GUNKUL Intranet</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
<?php
include("DB_Include.php");
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // เก็บข้อมูลจากฟอร์ม
  $Send_Code = isset($_POST['Send_Code']) ? $_POST['Send_Code'] : 0;
  $Send_Relation = isset($_POST['Send_Relation']) ? $_POST['Send_Relation'] : 0;
  $Send_Sort = !empty($_POST['Send_Sort']) ? $_POST['Send_Sort'] : 0;
  $Send_Text = $_POST['Send_Text'];
  $Send_descriptionth = $_POST['Send_descriptionth'];
  $Send_descriptionen = $_POST['Send_descriptionen'];
  $Type = $_POST['Send_MenuCategoryType'];

  // echo '-----'.$Send_Code.'++++'.$Send_Relation.'****'.$Send_Text.'////'.$Type;
  $FullNameImage = '';
  $TypeLower = strtolower($Type);
  if ($TypeLower == 'headingcategories') {
      if (isset($_FILES['imageMenuCategory']) && $_FILES['imageMenuCategory']['error'] === UPLOAD_ERR_OK) {
        $Send_OldImage = isset($_POST['Send_OldImage']) ? $_POST['Send_OldImage'] : '';
        $PathFolderMenuCategory = 'img/DefaultImageHeadingCategory/';

        $file = $_FILES['imageMenuCategory'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
    
        // ตรวจสอบว่าเป็นไฟล์รูปภาพหรือไม่
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
          if ($Send_Code == 0 || $Send_Code == '') {
            $sql = "SHOW TABLE STATUS LIKE 'headingcategories'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $maxCode = $row['Auto_increment'];
    
                if (!empty($maxCode)) {
                    $newnNameImage = $maxCode;
                } else {
                    $newnNameImage = 1;
                }
            } else {
                $newnNameImage = 1;
            }
          } else {
            $newnNameImage = $Send_Code;
          }
    
          $FullNameImage = $newnNameImage.'.'.$fileExtension;
          unset($sql);
    
          if ($Send_OldImage != ''){
            $filePath = $PathFolderMenuCategory . $Send_OldImage;
            if (file_exists($filePath)) {
              if (unlink($filePath)) {
              }
            }
          }
    
          $destination = $PathFolderMenuCategory . $FullNameImage;
          if (!file_exists($PathFolderMenuCategory)) {
            mkdir($PathFolderMenuCategory, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
          }
          move_uploaded_file($fileTmpName, $destination);
        } else {
          $_SESSION['StatusTitle'] = "Error!"; // รูปแบบไฟล์ไม่ถูกต้อง
          $_SESSION['StatusMessage'] = "Invalid file format.";
          $_SESSION['StatusAlert'] = "error";
          if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
            header("Location: ".$_SESSION['PathPage']);
            unset($_SESSION['PathPage']);
          }
          exit;
        }
    }
  }

  if ($Send_Code == 0 || $Send_Code == '') {
    switch ($TypeLower) {
      case "headingcategories":
        if ($FullNameImage == '') {
          $sql = "INSERT INTO `headingcategories` (`HC_Code`, `HC_Text`, `HC_descriptionth`, `HC_descriptionen`, `HC_UserCreate`, `HC_CreateDate`, `HC_ModifyDate`) VALUES (NULL, '$Send_Text', '$Send_descriptionth', '$Send_descriptionen', '$globalCurrentUser', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        } else {
          $sql = "INSERT INTO `headingcategories` (`HC_Code`, `HC_Text`, `HC_descriptionth`, `HC_descriptionen`, `HC_UserCreate`, `HC_DefaultImage`, `HC_CreateDate`, `HC_ModifyDate`) VALUES (NULL, '$Send_Text', '$Send_descriptionth', '$Send_descriptionen', '$globalCurrentUser', '$FullNameImage', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        }
        // echo 'a';
        break;
      case "headinggroup":
        $sql = "INSERT INTO `headinggroup` (`HG_Code`, `HG_Text`, `HG_Active`, `HG_Sort`, `HC_Code`, `HG_UserCreate`, `HG_CreateDate`, `HG_ModifyDate`) VALUES (NULL, '$Send_Text', '1', $Send_Sort, '$Send_Relation', '$globalCurrentUser', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        // echo 'b';
        $resultMasterHeadingCategories = $conn->query("SELECT * FROM `masterheadingcategories` WHERE `HC_Code` = $Send_Relation ORDER BY `MC_Code` ASC;");
        if ($resultMasterHeadingCategories->num_rows > 0) {
          if ($conn->query($sql) === true) {
              $sql = "";
              $insertedHG_Code = $conn->insert_id;    
              // นำข้อมูลที่ได้จาก headinggroup มาเพิ่มเข้าไปในตาราง heading โดย loop ผ่านทุก row ที่ได้จาก masterheadingcategories
              while ($rowMasterHeadingCategories = $resultMasterHeadingCategories->fetch_assoc()) {
                  $MC_Text = $rowMasterHeadingCategories["MC_Text"];
                  $sql .= "INSERT INTO `heading` (`HD_Code`, `HD_Text`, `HD_Active`, `HG_Code`, `HD_UserCreate`, `HD_CreateDate`, `HD_ModifyDate`) VALUES (NULL, '$MC_Text', '1', '$insertedHG_Code', '$globalCurrentUser', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
              }
          } else {
              $_SESSION['StatusTitle'] = "Error!";
              $_SESSION['StatusMessage'] = "Error: ".$conn->error;
              $_SESSION['StatusAlert'] = "error";
              if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                header("Location: ".$_SESSION['PathPage']);
                unset($_SESSION['PathPage']);
              }
          }
        }
        break;
      case "heading":
        $sql = "INSERT INTO `heading` (`HD_Code`, `HD_Text`, `HD_Active`, `HD_Sort`, `HG_Code`, `HD_UserCreate`, `HD_CreateDate`, `HD_ModifyDate`) VALUES (NULL, '$Send_Text', '1', $Send_Sort, '$Send_Relation', '$globalCurrentUser' , CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        // echo 'c';
        break;
      case "details":
        $sql = "INSERT INTO `details` (`DT_Code`, `DT_Text`, `DT_Active`, `DT_Sort`, `HD_Code`,`DT_UserCreate` , `DT_CreateDate`, `DT_ModifyDate`) VALUES (NULL, '$Send_Text', '1', $Send_Sort, '$Send_Relation', '$globalCurrentUser' , CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
        // echo 'd';
        break;
      default:
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
          $_SESSION['StatusAlert'] = "error";
          break;
    }
  } else {    
    switch ($TypeLower) {
      case "headingcategories":
        if ($FullNameImage == '') {
          $sql = "UPDATE `headingcategories` SET `HC_Text` = '$Send_Text', `HC_descriptionth` = '$Send_descriptionth', `HC_descriptionen` = '$Send_descriptionen',`HC_ModifyDate` = CURRENT_TIMESTAMP WHERE `headingcategories`.`HC_Code` = $Send_Code;";
        } else {
          $sql = "UPDATE `headingcategories` SET `HC_Text` = '$Send_Text', `HC_descriptionth` = '$Send_descriptionth', `HC_descriptionen` = '$Send_descriptionen',`HC_ModifyDate` = CURRENT_TIMESTAMP, `HC_DefaultImage` = '$FullNameImage' WHERE `headingcategories`.`HC_Code` = $Send_Code;";
        }
          // echo 'aa';
          break;
      case "headinggroup":
          $sql = "UPDATE `headinggroup` SET `HG_Text` = '$Send_Text', `HG_Sort` = $Send_Sort, `HG_ModifyDate` = CURRENT_TIMESTAMP WHERE `headinggroup`.`HG_Code` = $Send_Code;";
          // echo 'bb';
          break;
      case "heading":
          $sql = "UPDATE `heading` SET `HD_Text` = '$Send_Text', `HD_Sort` = $Send_Sort, `HD_ModifyDate` = CURRENT_TIMESTAMP WHERE `heading`.`HD_Code` = $Send_Code;";
          // echo 'cc';
          break;
      case "details":
          $sql = "UPDATE `details` SET `DT_Text` = '$Send_Text', `DT_Sort` = $Send_Sort, `DT_ModifyDate` = CURRENT_TIMESTAMP WHERE `details`.`DT_Code` = $Send_Code;";
          // echo 'dd';
          break;
      default:
          $_SESSION['StatusTitle'] = "Error!";
          $_SESSION['StatusMessage'] = "เกิดข้อผิดพลาดในการอัพเดชข้อมูล";
          $_SESSION['StatusAlert'] = "error";
          exit;
          break;
    }
  }
  if ($conn->multi_query($sql) === true) {
      $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
      $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
      $_SESSION['StatusAlert'] = "success";
  } else {
      $_SESSION['StatusTitle'] = "Error!";
      $_SESSION['StatusMessage'] = "Error: ".$conn->error;
      $_SESSION['StatusAlert'] = "error";
      if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
        header("Location: ".$_SESSION['PathPage']);
        unset($_SESSION['PathPage']);
      }
  }

  // ปิดการเชื่อมต่อฐานข้อมูล
  $conn->close();

  // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
  echo "<script> setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
}
?>
</head>
</html>