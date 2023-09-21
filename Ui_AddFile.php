<!-- PHP -->
<?php 
include("DB_Include.php"); 
include("DB_Setup.php");
if (isset($_GET['Send_Category']) && $_GET['Send_Category'] !== '') {
    $Send_Category = $_GET['Send_Category'];
    $_SESSION['PathPage'] = "AddFile?Send_Category=".$Send_Category;
} else {
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = 'ไม่มีหมวดหมู่';
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
    $CheckPage = false;
    $sql = "SELECT * FROM `permissionmenu` WHERE `permissionmenu`.`PM_RelationType` = 'Category' AND `permissionmenu`.`PM_RelationCode` = '$Send_Category' AND `permissionmenu`.`PM_Setup` = '1';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (CheckStatus($globalCurrentUser, $row["PM_Code"])) {
                $CheckPage = true;
            }
        }
    }
    if (!$CheckPage) {
        echo "<script>setTimeout(function() { window.location.href = `./Index`; }, 0); </script>";
    }
?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <?php
                    $sql = "SELECT * FROM `Category` WHERE `Category`.`CG_Entity No.` = $Send_Category;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $DescriptionTH = $row["CG_DescriptionTH"];
                        $DescriptionEN = $row["CG_DescriptionEN"];
                        $DefaultActive = $row["CG_DefaultActive"];
                    }
                ?>
                <h3 class="text-primary mb-0 mt-0"><?= $DescriptionEN ?></h3>
                <h2 class="mb-0 mt-0"><?= $DescriptionTH ?></h2>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <form action="Pro_AddFileActivities.php" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <input type="hidden" id="CategoryBegin_id" name="CategoryBegin_id" class="form-control border-1" value="<?= $Send_Category; ?>">
                            <input type="hidden" id="DefaultActive" name="DefaultActive" class="form-control border-1" value="<?= $DefaultActive; ?>">
                            <div class="col-6 col-sm-3">
                                <h6 class="text-primary">วันที่ลงข่าวและกิจกรรม</h6>
                                <input type="Date" id="DateAdd" name="DateAdd" class="form-control border-1" onload="getDate()" placeholder="วันที่ลงข่าวและกิจกรรม" required>
                            </div>

                            <div class="col-12 col-sm-3">
                                <h6 class="text-primary">หมวดหมู่</h6>
                                <select class="form-select border-1" id="Send_Category" name="Send_Category">
                                <?php
                                    $SelectFilterCategoryEntityNo = SearchCategorySub($Send_Category);
                                    $sql = "SELECT * FROM `category` WHERE (`CG_Entity No.` IN ($SelectFilterCategoryEntityNo));";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                ?>
                                    <option value="<?= $row["CG_Entity No."] ?>"><?= $row["CG_DescriptionTH"] ?></option>
                                <?php
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">

                                <h6 class="text-primary">ชื่อเรื่อง</h6>
                                <input type="text" id="title" name="Title" class="form-control border-1" placeholder="กรุณากรอกชื่อเรื่อง" required>
                            </div>
                            <div class="col-12">
                                <h6 class="text-primary">เนื้อหาย่อ</h6>
                                <input type="text" id="Summary" name="Summary" class="form-control border-1" placeholder="กรุณากรอกเนื้อหาย่อ" require>
                            </div>
                            <div class="col-12">
                                <h6 class="text-primary">ไฟล์ที่ต้องการจะจัดเก็บ</h6>
                                <input type="file" class="form-control border-1" name="file" id="file" accept=".pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx" required>
                            </div>
                            <div class="text-center col-12">
                                <button class="btn btn-danger rounded-pill py-2 px-5" type="button" onclick="window.history.back();">ยกเลิก</button>
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
    <!-- Date -->
    <script>
        var today = new Date();
        document.getElementById("DateAdd").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    </script>
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