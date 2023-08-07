<!-- PHP -->
<?php 
include("DB_Include.php"); 
include("DB_Setup.php");
$_SESSION['PathPage'] = "Ui_EditFile.php";
if (isset($_GET['Send_IDNews']) && $_GET['Send_IDNews'] !== '') {
    $t_id = $_GET['Send_IDNews'];
    $Category_id = $_GET['Send_Category'];
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
?>

<?php include("Fn_RecursiveCategory.php"); ?>
<?php include("Ma_Head_Link.php"); ?>
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>
<?php
    $sql = "SELECT * FROM `FileActivities` LEFT JOIN `Setup`ON 1 = `Setup`.`SU_Code` LEFT JOIN `category` ON `FileActivities`.`FA_Entity No.` = `category`.`CG_Entity No.` WHERE `FileActivities`.`FA_Code` = $t_id;";
        
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $FA_Date = $row["FA_Date"];
        $FA_Title = $row["FA_Title"];
        $FA_Description = $row["FA_Description"];
        $FA_File = $row["FA_File"];
        $CategoryID = $row["FA_Entity No."];
    } else {
        $FA_Date = "";
        $FA_Title = "";
        $FA_Description = "";
        $FA_File = "";
        $CategoryID = 0;
    }
?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <?php
                    $sql = "SELECT * FROM `Category` WHERE `Category`.`CG_Entity No.` = $Category_id;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $DescriptionTH = $row["CG_DescriptionTH"];
                        $DescriptionEN = $row["CG_DescriptionEN"];
                    }
                ?>
                <h6 class="text-primary">Form <?= $DescriptionEN ?></h6>
                <h2 class="mb-4">สร้าง<?= $DescriptionTH ?></h2>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <form action="Pro_EditFileActivities.php" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <input type="hidden" id="ID" name="ID" class="form-control border-1" value="<?= $t_id; ?>">
                            <input type="hidden" id="CategoryBegin_id" name="CategoryBegin_id" class="form-control border-1" value="<?= $Category_id; ?>">
                            <div class="col-6 col-sm-3">
                                <h6 class="text-primary">วันที่ลงข่าวและกิจกรรม</h6>
                                <input type="Date" id="DateAddNews" name="DateAddNews" class="form-control border-1" value="<?= $FA_Date; ?>" placeholder="วันที่ลงข่าวและกิจกรรม" required>
                            </div>
                            <div class="col-12 col-sm-3">
                                <h6 class="text-primary">หัวข้อย่อย</h6>
                                <select class="form-select border-1" id="Send_Category" name="Send_Category">
                                    <?php
                                        $SelectFilterCategoryEntityNo = SearchCategorySub($Category_id);
                                        echo $SelectFilterCategoryEntityNo;
                                        $sql = "SELECT * FROM `category` WHERE (`CG_Entity No.` IN ($SelectFilterCategoryEntityNo));";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = ($row["CG_Entity No."] == $CategoryID) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $row["CG_Entity No."] ?>" <?= $selected ?>><?= $row["CG_DescriptionTH"] ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h6 class="text-primary">ชื่อเรื่อง</h6>
                                <input type="text" id="title" name="Title" class="form-control border-1" value="<?php echo htmlspecialchars($FA_Title, ENT_QUOTES); ?>" placeholder="กรุณากรอกชื่อเรื่อง" required>
                            </div>
                            <div class="col-12">
                                <h6 class="text-primary">เนื้อหาย่อ</h6>
                                <input type="text" id="Summary" name="Summary" class="form-control border-1" value="<?php echo htmlspecialchars($FA_Description, ENT_QUOTES); ?>" placeholder="กรุณากรอกเนื้อหาย่อ" require>
                            </div>
                            <div class="col-12">
                                <h6 class="text-primary">ไฟล์ที่ต้องการจะจัดเก็บ</h6>
                                <input type="hidden" id="fileNameInput" name="fileNameInput" value="<?= $FA_File; ?>" readonly>
                                <input type="file" class="form-control border-1" name="file" id="file" accept=".pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx">
                            </div>
                            <div class="text-center col-12">
                                <button class="btn btn-primary rounded-pill py-2 px-5" type="submit">บันทึก</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Content -->

<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
    <!-- sweetalert -->
    <script>
            // ตรวจสอบว่ามีข้อความใน Session หรือไม่
        <?php if (isset($_SESSION['StatusMessage'])) : ?>
            // แสดงข้อความแจ้งเตือนเมื่อโหลดหน้า
            window.onload = function() {
                swal("<?php echo $_SESSION['StatusTitle']; ?>", "<?php echo $_SESSION['StatusMessage']; ?>", "<?php echo $_SESSION['StatusAlert']; ?>");
                <?php unset($_SESSION['StatusTitle'], $_SESSION['StatusMessage'], $_SESSION['StatusAlert']); ?> // ลบค่าใน Session เพื่อไม่ให้แสดงซ้ำ
            };
        <?php endif; ?>
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/adminlte.min.js"></script>
<?php include("Ma_Footer_Script.php"); ?>