<?php 
include("DB_Include.php"); 
$_SESSION['PathPage'] = "AdminSetup.php";
?>

<?php include("Ma_Head_Link.php"); ?>
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
  #image {
    display: none;
  }
</style>
<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>
<?PHP
    $sql = "SELECT * FROM Setup";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $CodeSetup = $row["SU_Code"];
        $DefaultImageNews = $row["SU_DefaultImageNews"];
        $PathFolderNews = $row["SU_PathDefaultImageNews"];
        $PathFolderGallery = $row["SU_PathDefaultImageGallery"];
    } else {
        unset($sql);
        $sql = "INSERT INTO `Setup` (`CG_Entity No.`,`CG_CreateDate`) VALUES (1, CURRENT_TIMESTAMP)";
        if ($conn->query($sql) === true) {
            $CodeSetup = 1;
            $DefaultImageNews = "";
            $PathFolderNews = "";
            $PathFolderGallery = "";
        }
    }
    unset($sql);
?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">Setup & Set system defaults.</h6>
                <h2 class="mb-4">ตั้งค่าและเซตค่าเริ่มต้นระบบ</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <section class="content">
                    <form action="Pro_EditSetup.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">ข่าวสารและกิจกรรม</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="inputName">รูปเริ่มต้นของข่าวและกิจกรรม</label>
                                            <div class="container-fluid bg-light overflow-hidden my-3 px-lg-0">
                                                <div class="container quote px-lg-0">
                                                    <div class="row g-0 mx-lg-0">
                                                        <div class="col-lg-4 quote-text py-0 wow fadeIn" data-wow-delay="0.5s"></div>
                                                        <div class="col-lg-4 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="max-height: 200px; max-width: 200px; min-height: 100px; min-width: 100px;">
                                                            <div class="position-relative">
                                                                <input type="file" class="form-control border-1" name="image" id="image" accept="image/*">
                                                                <input type="hidden" name="ID" value="<?= $CodeSetup ?>" class="form-control">
                                                                <input type="hidden" name="DefaultNameImageNews" value="0" class="form-control">
                                                                <input type="hidden" name="OldNameImageNews" value="<?= $DefaultImageNews ?>" class="form-control">
                                                                <label for="image" style="cursor: pointer;">
                                                                    <?php
                                                                    if (isset($DefaultImageNews) && $DefaultImageNews !== '') {
                                                                        $PathDefaultImage = $PathFolderNews . $DefaultImageNews;
                                                                    } else {
                                                                        $folderPath = 'Default/DefaultImage/';
                                                                        $files = scandir($folderPath);
                                                                        $imageFiles = array_diff($files, array('.', '..'));
                                                                        $latestImage = '';
                                                                        $latestTimestamp = 0;
                                                                        foreach ($imageFiles as $imageFile) {
                                                                            $filePath = $folderPath . $imageFile;
                                                                            $timestamp = filemtime($filePath);

                                                                            if ($timestamp > $latestTimestamp) {
                                                                                $latestTimestamp = $timestamp;
                                                                                $latestImage = $imageFile;
                                                                            }
                                                                        }
                                                                        if (!empty($latestImage)) {
                                                                            $PathDefaultImage = $folderPath . $latestImage;
                                                                        } else {
                                                                            echo "ไม่พบภาพในโฟลเดอร์";
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <img id="previewImage" class="img-fluid rounded" src="<?= $PathDefaultImage ?>" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 quote-text py-0 wow fadeIn" data-wow-delay="0.5s"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="PathFolderNews">ที่เก็บที่อยู่รูปข่าว</label>
                                            <input type="text" name="PathFolderNews" value="<?= $PathFolderNews; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="PathFolderNews">ที่เก็บแกลลอรี่</label>
                                            <input type="text" name="PathFolderGallery" value="<?= $PathFolderGallery; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-secondary collapsed-card">
                                        <div class="card-header">
                                            <h3 class="card-title text-white">มีไว้ก่อน</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                        <div class="form-group">
                                            <label>ว่าง</label>
                                            <input type="number"  class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>ว่าง</label>
                                            <input type="number" class="form-control">
                                        </div>
                                            <div class="form-group">
                                                <label>ว่าง</label>
                                                <input type="number"  class="form-control">
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <input type="submit" value="บันทึก" class="btn btn-success float-right">
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <!-- Content -->

<?php include("Ma_Footer.php"); ?>
    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                var previewImage = document.getElementById('previewImage');
                previewImage.src = e.target.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                var defaultImagePath = document.getElementById('DefaultNameImageNews').value;
                previewImage.src = defaultImagePath;
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
    <script src="js/jquery.min.js"></script>
    <script src="js/adminlte.min.js"></script>
<?php include("Ma_Footer_Script.php"); ?>