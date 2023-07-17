<?PHP
    $DefaultImageNews = '';
    $PathFolderNews = '';

    $sql = "SELECT * FROM Setup";
    $result = $conn->query($sql);

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
        // ดำเนินการกับข้อมูลที่ได้รับ
        $row = $result->fetch_assoc();
        handleSetupData($row);
    } else {
        $sql = "INSERT INTO `Setup` (`CG_Entity No.`,`CG_CreateDate`) VALUES (1, CURRENT_TIMESTAMP)";
        if ($conn->query($sql) === true) {
            handleSetupData($row);
        } else {
            ReturnPage('ไม่สามารถเพิ่มข้อมูลเบื่องต้นได้');
        }
        // ReturnPage('กรุณากลับไป Setup ก่อน');
    }  
    unset($sql);

    function ReturnPage($TextMessage) {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = $TextMessage;
        $_SESSION['StatusAlert'] = "error";
        if (isset($_SESSION['PathPage']) && $_SESSION['PathPage'] !== '') {
            header("Location: ".$_SESSION['PathPage']);
            unset($_SESSION['PathPage']);
        }
        exit();
      }

    function handleSetupData($row) {
        global $DefaultImageNews, $PathFolderNews;
        if (isset($row["SU_DefaultImageNews"]) && $row["SU_DefaultImageNews"] !== '') {
            $DefaultImageNews = $row["SU_DefaultImageNews"];
        } else {
            ReturnPage('กรุณากลับไป Setup ค่าเริ่มต้นเมื่อไม่มีภาพก่อน');
        }
        if (isset($row["SU_PathDefaultImageNews"]) && $row["SU_PathDefaultImageNews"] !== '') {
            $PathFolderNews = $row["SU_PathDefaultImageNews"];
        } else {
            ReturnPage('กรุณากลับไป Setup ที่อยู่รูปภาพของข่าวก่อน');
        }
        if (isset($row["SU_PathDefaultImageGallery"]) && $row["SU_PathDefaultImageGallery"] !== '') {
            $PathFolderGallery = $row["SU_PathDefaultImageGallery"];
        } else {
            ReturnPage('กรุณากลับไป Setup ที่อยู่รูปภาพของข่าวก่อน');
        }
    }
?>