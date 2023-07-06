<!-- PHP -->
<?php 
include("DB_Include.php"); 
$_SESSION['PathPage'] = "News_Edit.php";
if (isset($_GET['Send_IDNews']) && $_GET['Send_IDNews'] !== '') {
    $t_id = $_GET['Send_IDNews'];
} else {
    $_SESSION['StatusTitle'] = "Error!";
    $_SESSION['StatusMessage'] = 'ไม่พบเลขที่เอกสารนี้';
    $_SESSION['StatusAlert'] = "error";
    header("Location: ".$_SESSION['PathPage']);
    unset($_SESSION['PathPage']);
    exit();
}
?>

<?php include("Head_Link.php"); ?>
<!-- Icon Font Stylesheet -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- dataTables Stylesheet -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<?php include("Head.php"); ?>
<?php include("Carousel.php"); ?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">Form News & Activities</h6>
                <h1 class="mb-4">สร้างข่าวสารและกิจกรรม</h1>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <form action="Pro_EditNews.php" method="post" enctype="multipart/form-data">
                        <?php
                            $sql = "SELECT * FROM `news` LEFT JOIN `newssetup`ON 1 = `newssetup`.`SU_Code` WHERE `news`.`NA_Code` = $t_id;";
                            
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $NA_Date = $row["NA_Date"];
                                $NA_Title = $row["NA_Title"];
                                $NA_Description = $row["NA_Description"];
                                $NA_Note = base64_decode($row["NA_Note"]);
                                if ($NA_Note !== false) {
                                    $NA_Note;
                                    echo 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                                } else {
                                    $NA_Note = $row["NA_Note"];
                                    echo 'BBBBBBBBBBBBBBBBBBBBBBBBBBBB';
                                }
                                // $NA_Note = base64_decode($row["NA_Note"]);
                                // $NA_Note = $row["NA_Note"];
                                $NA_Image = $row["NA_Image"];
                                $SU_PathDefaultImageNews = $row["SU_PathDefaultImageNews"];
                            } else {
                                $NA_Date = "";
                                $NA_Title = "";
                                $NA_Description = "";
                                $NA_Note = "";
                                $NA_Image = "";
                                $SU_PathDefaultImageNews = "";
                            }
                        ?>
                        <div class="row g-3">
                            <input type="hidden" id="ID" name="ID" class="form-control border-1" value="<?= $t_id; ?>">
                            <div class="col-6 col-sm-3">
                                <h6 class="text-primary">วันที่ลงข่าวและกิจกรรม</h6>
                                <input type="Date" id="DateAddNews" name="DateAddNews" class="form-control border-1" value="<?= $NA_Date; ?>" placeholder="วันที่ลงข่าวและกิจกรรม" required>
                            </div>
                            <div class="col-12 col-sm-9">
                                <h6 class="text-primary">ชื่อเรื่อง</h6>
                                <input type="text" id="title" name="Title" class="form-control border-1" value="<?php echo htmlspecialchars($NA_Title, ENT_QUOTES); ?>" placeholder="กรุณากรอกชื่อเรื่อง" required>
                            </div>
                            <div class="col-12">
                                <h6 class="text-primary">เนื้อหาย่อ</h6>
                                <input type="text" id="Summary" name="Summary" class="form-control border-1" value="<?php echo htmlspecialchars($NA_Description, ENT_QUOTES); ?>" placeholder="กรุณากรอกเนื้อหาย่อ" require>
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
                                                <img id="previewImage" class="img-fluid rounded" src="<?= $SU_PathDefaultImageNews.$NA_Image; ?>" style="object-fit: cover;" alt="">
                                                <!-- <img id="previewImage" class="position-absolute img-fluid" src="..." style="object-fit: cover;" alt=""> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6 quote-text py-0 wow fadeIn" data-wow-delay="0.5s">
                                            <div class="p-lg-5 pe-lg-0">
                                                <h6 class="text-primary">เลือกไฟล์แสดงหน้าหลัก</h6><p class="mb-4 pb-2">สามารถเลือกได้เพียง 1 ภาพ</p>
                                                <input type="hidden" id="fileNameInput" name="fileNameInput" value="<?= $NA_Image; ?>" readonly>
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

<?php include("Footer.php"); ?>
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
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
                $('#summernote').summernote('code', <?= json_encode($NA_Note); ?>);
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
<?php include("Footer_Script.php"); ?>