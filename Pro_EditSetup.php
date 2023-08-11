<?php
include("DB_Include.php");
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

// เช็คว่ามีการส่งข้อมูลผ่านแบบ POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // เก็บข้อมูลจากฟอร์ม

  $ID = isset($_POST['ID']) ? $_POST['ID'] : null;
  if ($ID !== null) {
    $DefaultNameImageNews = $_POST['DefaultNameImageNews'];
    $OldNameImageNews = $_POST['OldNameImageNews'];
    $PathFolderNews = $_POST['PathFolderNews'];
    $PathFolderGallery = $_POST['PathFolderGallery'];
    $PathDefaultFile = $_POST['PathDefaultFile'];
  
    // เก็บข้อมูลไฟล์
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
  
    $newnFullNameImage = $OldNameImageNews;
  
    // echo "1".$ID."-----".$DefaultNameImageNews."=========".$OldNameImageNews."-------------------".$PathFolderNews;
  
    // เช็คว่ามีข้อผิดพลาดในการอัปโหลดไฟล์หรือไม่
    if ($fileError === UPLOAD_ERR_OK) {
      // เช็คประเภทไฟล์
      $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
  
          // ลบไฟล์เก่า
        if (!empty($newnFullNameImage)) {
          $filePath = $PathFolderNews . $newnFullNameImage;
          if (file_exists($filePath)) {
              if (unlink($filePath)) {
                  // echo 'File deleted successfully.';
              } else {
                  $_SESSION['StatusTitle'] = "Error!";
                  $_SESSION['StatusMessage'] = "Unable to delete the file.";
                  $_SESSION['StatusAlert'] = "error";
                  if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                    header("Location: ".$_SESSION['PathPage']);
                    unset($_SESSION['PathPage']);
                  }
              }
          } else {
              $_SESSION['StatusTitle'] = "Error!";
              $_SESSION['StatusMessage'] = "File not found.";
              $_SESSION['StatusAlert'] = "error";
              if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                header("Location: ".$_SESSION['PathPage']);
                unset($_SESSION['PathPage']);
              }
          }
        }
  
      if (in_array($fileType, $allowedExtensions)) {
        $EditNameImage = $DefaultNameImageNews;
        
        $newnFullNameImage = $EditNameImage.'.'.$fileType;
        // ย้ายไฟล์ไปยังตำแหน่งที่ต้องการ (เช่นโฟลเดอร์ uploads)
        $destination = $PathFolderNews . $newnFullNameImage;
        if (!file_exists($PathFolderNews)) {
          mkdir($PathFolderNews, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
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
      }
    } else {
      $newnFullNameImage = '';
    }
  
    $sql = "UPDATE `newsandactivities`.`Setup` SET `SU_PathDefaultImageNews` = '$PathFolderNews', `SU_PathDefaultImageGallery` = '$PathFolderGallery', `SU_PathDefaultFile` = '$PathDefaultFile'";
  
    if (!empty($newnFullNameImage) && $newnFullNameImage !== '') { 
        $sql .= ", `SU_DefaultImageNews` = '$newnFullNameImage'";
    }
    
    $sql .= " WHERE `Setup`.`SU_Code` = $ID;";
    // ดำเนินการ INSERT ข้อมูล
    if ($conn->query($sql) === true) {
      // $_SESSION['StatusMessage'] = 'กรุณากลับไป Setup ก่อน';
      //     header("Location: ".$_SESSION['PathPage']);
      //     exit();
      // echo '<script>swal("Success.");</script>';
      // if (isset($_POST["Games"]) && is_array($_POST["Games"])) {
      //   AddSetupGames($_POST['Games']);
      // }
      $_SESSION['StatusTitle'] = "ดำเนินการเรียบร้อยแล้ว";
      $_SESSION['StatusMessage'] = "ทำการอัพเดชเรียบร้อบแล้ว";
      $_SESSION['StatusAlert'] = "success";
    } else {
      if (!empty($newnFullNameImage)) {
        echo $conn->error;
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = "Error: ".$conn->error;
        $_SESSION['StatusAlert'] = "error";
        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
          header("Location: ".$_SESSION['PathPage']);
          unset($_SESSION['PathPage']);
        }
        $filePath = $PathFolderNews . $newnFullNameImage;
  
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                // echo 'File deleted successfully.';
            } else {
                $_SESSION['StatusTitle'] = "Error!";
                $_SESSION['StatusMessage'] = "Unable to delete the file.";
                $_SESSION['StatusAlert'] = "error";
                if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
                  header("Location: ".$_SESSION['PathPage']);
                  unset($_SESSION['PathPage']);
                }
            }
        } else {
            $_SESSION['StatusTitle'] = "Error!";
            $_SESSION['StatusMessage'] = "File not found.";
            $_SESSION['StatusAlert'] = "error";
            if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
              header("Location: ".$_SESSION['PathPage']);
              unset($_SESSION['PathPage']);
            }
        }
      }
    }
  } else {
    if (isset($_POST["Games"]) && is_array($_POST["Games"])) {
      AddSetupGames($_POST['Games']);
    }
  }

  // ปิดการเชื่อมต่อฐานข้อมูล
  $conn->close();

  // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
   echo '<script> setTimeout(function() { window.location.href = "./Ui_AdminSetup.php"; }, 0); </script>';
}

function AddSetupGames($GamesArray) {   
  global $conn;
  // ตรวจสอบว่ามีค่า Gram ที่ถูกส่งมาหรือไม่
  if (isset($GamesArray) && is_array($GamesArray)) {
      $query = "TRUNCATE TABLE setupgames;";
      $conn->query($query);

      // แสดงค่าที่ถูกส่งมา
      foreach ($GamesArray as $index => $gram) {
        if ($gram != '') {
          // echo "Gram[$index]: $gram<br>";
          $query = "INSERT INTO `newsandactivities`.`SetupGames` (`GA_Code`, `GA_Iframe`, `GA_CreateDate`, `GA_ModifyDate`) VALUES (NULL, '$gram', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
          if ($conn->query($query) !== true) {
              echo "Error: " . $query . "<br>" . $conn->error;
          }
        }
      }
  } else {
      echo "ไม่พบข้อมูล Gram ที่ถูกส่งมา";
  }
}
?>

