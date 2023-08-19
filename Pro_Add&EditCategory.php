<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GUNKUL Engineering (GUNKUL)</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
<?php
include("DB_Include.php");
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // เก็บข้อมูลจากฟอร์ม
  $CG_EntityNo = isset($_POST['CG_EntityNo']) ? $_POST['CG_EntityNo'] : 0;
  $CG_EntityRelationNo = isset($_POST['CG_EntityRelationNo']) ? $_POST['CG_EntityRelationNo'] : 0; 
  $CG_IsFile = isset($_POST['CG_IsFile']) && $_POST['CG_IsFile'] === 'on' ? 1 : 0;
  $CG_Name = $_POST['CG_Name'];
  $CG_DescriptionTH = $_POST['CG_DescriptionTH'];
  $CG_DescriptionEN = $_POST['CG_DescriptionEN'];
  $CG_OldImage = $_POST['CG_OldImage'];

  // เก็บข้อมูลไฟล์
  $file = $_FILES['imageCategory'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  // echo $CG_EntityNo.'--'.$CG_EntityRelationNo.'++'.$CG_Name.'//'.$CG_DescriptionTH.'=='.$CG_DescriptionEN.'..'.$CG_IsFile;
  $FullNameImage = '';

  // เช็คว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
  if ($fileError === UPLOAD_ERR_OK) {
    $PathFolderCategory = 'img/DefaultImageCategory/';
    // เช็คประเภทไฟล์
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedExtensions)) {
      if ($CG_EntityNo == 0 || $CG_EntityNo == '') {
        $sql = "SHOW TABLE STATUS LIKE 'category'";
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
        $newnNameImage = $CG_EntityNo;
      }

      $FullNameImage = $newnNameImage.'.'.$fileType;
      unset($sql);

      if ($CG_OldImage != ''){
        $filePath = $PathFolderCategory . $CG_OldImage;
        if (file_exists($filePath)) {
          if (unlink($filePath)) {
          }
        }
      }

      $destination = $PathFolderCategory . $FullNameImage;
      if (!file_exists($PathFolderCategory)) {
        mkdir($PathFolderCategory, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
      }
      move_uploaded_file($fileTmpName, $destination);
      // echo 'The file has been uploaded successfully. Its name is: ' . $FullNameImage; // ไฟล์ถูกอัปโหลดเรียบร้อยแล้วชื่อว่า
    } else {
      $_SESSION['StatusTitle'] = "Error!"; // รูปแบบไฟล์ไม่ถูกต้อง
      $_SESSION['StatusMessage'] = "Invalid file format.";
      $_SESSION['StatusAlert'] = "error";
      if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
        header("Location: ".$_SESSION['PathPage']);
        unset($_SESSION['PathPage']);
      }
    }
  }

  // ทำอย่างอื่นๆ เช่นบันทึกข้อมูลลงฐานข้อมูล
  if ($CG_EntityNo == 0 || $CG_EntityNo == '') {
    if ($FullNameImage == '') {
      $sql = "INSERT INTO `category` (`CG_Entity No.`, `CG_IsFile`, `CG_Entity Relation No.`, `CG_Name`, `CG_DescriptionTH`, `CG_DescriptionEN`, `CG_CreateDate`, `CG_ModifyDate`) VALUES (NULL, $CG_IsFile, $CG_EntityRelationNo, '$CG_Name', '$CG_DescriptionTH', '$CG_DescriptionEN', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    } else {
      $sql = "INSERT INTO `category` (`CG_Entity No.`, `CG_IsFile`, `CG_Entity Relation No.`, `CG_Name`, `CG_DescriptionTH`, `CG_DescriptionEN`, `CG_DefaultImage`, `CG_CreateDate`, `CG_ModifyDate`) VALUES (NULL, $CG_IsFile, $CG_EntityRelationNo, '$CG_Name', '$CG_DescriptionTH', '$CG_DescriptionEN', '$FullNameImage', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    }
  } else {
    $sqlCheck = "SELECT * FROM `category` WHERE `category`.`CG_Name` = '$CG_Name';";
    $resultCheck = $conn->query($sqlCheck);
    if ($resultCheck->num_rows > 0) {
      $rowCheck = $resultCheck->fetch_assoc();
      if ($rowCheck["CG_Entity No."] == $CG_EntityRelationNo) {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = "เนื่องจากต้องไม่สามารถเลือกในลำดับชั้นของตัวเองได้";
        $_SESSION['StatusAlert'] = "error";
        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
          header("Location: ".$_SESSION['PathPage']);
          unset($_SESSION['PathPage']);
          exit;
        }
      }
    }
      if ($FullNameImage == '') {
        $sql = "UPDATE `category` SET `CG_IsFile` = $CG_IsFile, `CG_Entity Relation No.` = $CG_EntityRelationNo, `CG_Name` = '$CG_Name', `CG_DescriptionTH` = '$CG_DescriptionTH', `CG_DescriptionEN` = '$CG_DescriptionEN',`CG_ModifyDate` = CURRENT_TIMESTAMP WHERE `category`.`CG_Entity No.` = $CG_EntityNo;";
      } else {
        $sql = "UPDATE `category` SET `CG_IsFile` = $CG_IsFile, `CG_Entity Relation No.` = $CG_EntityRelationNo, `CG_Name` = '$CG_Name', `CG_DescriptionTH` = '$CG_DescriptionTH', `CG_DescriptionEN` = '$CG_DescriptionEN',`CG_ModifyDate` = CURRENT_TIMESTAMP, `CG_DefaultImage` = '$FullNameImage' WHERE `category`.`CG_Entity No.` = $CG_EntityNo;";
      }
  }
  if ($conn->query($sql) === true) {
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
  echo '<script> setTimeout(function() { window.location.href = "./Ui_AdminSetup.php"; }, 0); </script>';
}

?>
</head>
</html>