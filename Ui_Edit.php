<!-- PHP -->
<?php 
include("DB_Include.php"); 
$_SESSION['PathPage'] = "Ui_Edit.php";
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
<!-- Icon Font Stylesheet -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- dataTables Stylesheet -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>
<?php
    $sql = "SELECT * FROM `Activities` LEFT JOIN `Setup`ON 1 = `Setup`.`SU_Code` LEFT JOIN `category` ON `Activities`.`AT_Entity No.` = `category`.`CG_Entity No.` WHERE `Activities`.`AT_Code` = $t_id;";
        
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $AT_Date = $row["AT_Date"];
        $AT_Title = $row["AT_Title"];
        $AT_Description = $row["AT_Description"];
        $AT_Note = base64_decode($row["AT_Note"]);
        if ($AT_Note !== false) {
            $AT_Note;
        } else {
            $AT_Note = $row["AT_Note"];
        }
        $AT_Image = $row["AT_Image"];
        $SU_PathDefaultImageNews = $row["SU_PathDefaultImageNews"];
        $CategoryID = $row["CG_Entity No."];
    } else {
        $AT_Date = "";
        $AT_Title = "";
        $AT_Description = "";
        $AT_Note = "";
        $AT_Image = "";
        $SU_PathDefaultImageNews = "";
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
                    <form action="Pro_EditNews.php" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <input type="hidden" id="ID" name="ID" class="form-control border-1" value="<?= $t_id; ?>">
                            <input type="hidden" id="CategoryBegin_id" name="CategoryBegin_id" class="form-control border-1" value="<?= $Category_id; ?>">
                            <div class="col-6 col-sm-3">
                                <h6 class="text-primary">วันที่ลงข่าวและกิจกรรม</h6>
                                <input type="Date" id="DateAddNews" name="DateAddNews" class="form-control border-1" value="<?= $AT_Date; ?>" placeholder="วันที่ลงข่าวและกิจกรรม" required>
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
                            <!-- <div class="col-12 col-sm-9"> -->
                                <h6 class="text-primary">ชื่อเรื่อง</h6>
                                <input type="text" id="title" name="Title" class="form-control border-1" value="<?php echo htmlspecialchars($AT_Title, ENT_QUOTES); ?>" placeholder="กรุณากรอกชื่อเรื่อง" required>
                            </div>
                            <div class="col-12">
                                <h6 class="text-primary">เนื้อหาย่อ</h6>
                                <input type="text" id="Summary" name="Summary" class="form-control border-1" value="<?php echo htmlspecialchars($AT_Description, ENT_QUOTES); ?>" placeholder="กรุณากรอกเนื้อหาย่อ" require>
                            </div>
                            <div class="col-12">
                                <h6 class="text-primary">เนื้อหา</h6>
                                <textarea class="form-control border-1" name="summernote" id="summernote"></textarea>
                            </div>
                            <div class="container-fluid bg-light overflow-hidden my-3 px-lg-0">
                                <div class="container quote px-lg-0">
                                    <div class="row g-0 mx-lg-0">
                                        <div class="col-lg-6 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="max-height: 400px; max-width: 400px; min-height: 200px; min-width: 200px;">
                                            <div class="position-relative">
                                                <img id="previewImage" class="img-fluid rounded" src="<?= $SU_PathDefaultImageNews.$AT_Image; ?>" style="object-fit: cover;" alt="">
                                                <!-- <img id="previewImage" class="position-absolute img-fluid" src="..." style="object-fit: cover;" alt=""> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6 quote-text py-0 wow fadeIn" data-wow-delay="0.5s">
                                            <div class="p-lg-5 pe-lg-0">
                                                <h6 class="text-primary">เลือกไฟล์แสดงหน้าหลัก</h6><p class="mb-4 pb-2">สามารถเลือกได้เพียง 1 ภาพ</p>
                                                <input type="hidden" id="fileNameInput" name="fileNameInput" value="<?= $AT_Image; ?>" readonly>
                                                <input type="file" class="form-control border-1" name="image" id="image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center col-12">
                                <button class="btn btn-danger rounded-pill py-2 px-5" type="reset">รีเซ็ต</button>
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
    <!-- <script src="https://momentjs.com/downloads/moment.min.js"></script> -->
    <!-- JavaScript Libraries -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        document.getElementById('image').addEventListener('change', function() {
            var file = this.files[0]; // เลือกไฟล์แรกที่เลือก
            var reader = new FileReader(); // ใช้ FileReader เพื่ออ่านข้อมูลของไฟล์

            reader.onload = function(e) {
                // เมื่ออ่านไฟล์สำเร็จ
                var previewImage = document.getElementById('previewImage');
                previewImage.src = e.target.result; // กำหนดค่า src ของภาพให้เป็นข้อมูลที่อ่านได้จาก FileReader
            };

            reader.readAsDataURL(file); // อ่านไฟล์ในรูปแบบ Data URL (base64)
        });
    </script>

    <!-- Summernote -->
    <script>
        $('#summernote').summernote({
            placeholder: 'กรุณากรอกข้อมูลที่จะแสดง',
            tabsize: 2,
            height: 450,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                $('#summernote').summernote('code', <?= json_encode($AT_Note); ?>);
                }
            }
        });
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
<?php include("Ma_Footer_Script.php"); ?>