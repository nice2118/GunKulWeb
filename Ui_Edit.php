<!-- PHP -->
<?php 
include("DB_Include.php"); 
include("DB_Setup.php");
if (isset($_GET['Send_IDNews']) && $_GET['Send_IDNews'] !== '') {
    $t_id = $_GET['Send_IDNews'];
    $Category_id = $_GET['Send_Category'];
    $_SESSION['PathPage'] = "Edit?Send_IDNews=".$Category_id;
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
    $CheckPage = false;
    $sql = "SELECT * FROM `permissionmenu` WHERE `permissionmenu`.`PM_RelationType` = 'Category' AND `permissionmenu`.`PM_RelationCode` = '$Category_id' AND `permissionmenu`.`PM_Setup` = '1';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (CheckStatus($currentUser, $row["PM_Code"])) {
                $CheckPage = true;
            }
        }
    }
    if (!$CheckPage) {
        echo "<script>setTimeout(function() { window.location.href = `./Index`; }, 0); </script>";
    }
?>
<?php
    $sql = "SELECT * FROM `Activities` LEFT JOIN `Setup`ON 1 = `Setup`.`SU_Code` LEFT JOIN `category` ON `Activities`.`AT_Entity No.` = `category`.`CG_Entity No.` WHERE `Activities`.`AT_Code` = $t_id;";
        
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $AT_Date = $row["AT_Date"];
        $AT_Title = $row["AT_Title"];
        $AT_Description = $row["AT_Description"];
        // $AT_Note = base64_decode($row["AT_Note"]);
        // if ($AT_Note !== false) {
        //     $AT_Note;
        // } else {
            $AT_Note = $row["AT_Note"];
        // }
        if ($row["AT_Image"] !== '') {
            $AT_Image = $row["AT_Image"];
        } else {
            $AT_Image = $row["SU_PathDefaultImageNews"];
        }
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
                <h3 class="text-primary">Form <?= $DescriptionEN ?></h3>
                <h2 class="mb-4">สร้าง<?= $DescriptionTH ?></h2>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <form action="Pro_EditActivities.php" method="post" enctype="multipart/form-data">
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
                            <div class="col-12">
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
                            </div>
                            <div class="col-md-12">
                                <!-- <div class="card card-primary collapsed-card"> -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">แกลลอรี่</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="image-container"></div>
                                            <input type="file" class="Image-Gallery" name="ImageGallery[]" accept="image/*, video/*" style="display: none;" multiple>
                                        </div>
                                        <div class="row">
                                            <div class="text-center col-12 text-center text-md-end">
                                                <button type="button" class="btn btn-danger rounded-pill py-2 px-3 delete-all-btn text-end my-3">ลบรูปทั้งหมดที่เพิ่มใหม่</button>
                                                <button type="button" class="btn btn-primary rounded-pill py-2 px-3 add-image-btn text-end my-3">เลือกรูปภาพ</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<?php include("Ma_ScriptGallery.php"); ?>
<?php
// สร้างคำสั่ง SQL สำหรับดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT `GR_Entity No.` AS `name`, CONCAT(
    CASE
        WHEN SUBSTRING_INDEX(`GR_Name`, '.', -1) IN ('jpg', 'jpeg', 'png', 'gif') THEN 'image/'
        WHEN SUBSTRING_INDEX(`GR_Name`, '.', -1) IN ('mp4', 'avi', 'mov') THEN 'video/'
        ELSE ''
    END,
    SUBSTRING_INDEX(`GR_Name`, '.', -1)
) AS `type`, CONCAT('$PathFolderGallery', `GR_Name`) AS `source` FROM `Gallery` WHERE `Gallery`.`GR_Activities Code` = $t_id";

$result = $conn->query($sql);
$imageData = array();

// วน loop เพื่อดึงข้อมูลและเก็บลงในตัวแปร $imageData
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imageData[] = $row;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// แปลงข้อมูลในรูปแบบ JSON
$jsonData = json_encode($imageData);
?>
<script>
// Retrieve image data from the database and display as images
function displayImagesFromDatabase() {
  var imageData = <?= $jsonData;?>;
//   console.log(imageData);
  imageData.forEach((data) => {
    const { name, type, source } = data;

    const imagePreview = document.createElement('div');
    imagePreview.classList.add('image-preview2');

    const image = document.createElement('img');
    const video = document.createElement('video');

    if (type.startsWith('image/')) {
      image.src = source;
      image.alt = name;
      imagePreview.appendChild(image);
    } else if (type.startsWith('video/')) {
      video.src = source;
      video.alt = name;
      video.controls = true;
      video.muted = true;
      video.loop = true;
      imagePreview.appendChild(video);

      video.addEventListener('loadeddata', () => {
        video.play();
      });
    }

    // Create delete button
    const deleteButton = document.createElement('button');
    deleteButton.classList.add('delete-image-btn', 'fa', 'fa-times');
    deleteButton.setAttribute('type', 'button');

    // Add event listener to the delete button
    deleteButton.addEventListener('click', () => {
    swal({
        title: "คุณต้องการที่จะลบหรือไม่?",
        text: "เมื่อกดลบรูปภาพแล้วจะไม่สามารถกู้คืนได้",
        icon: "warning",
        buttons: {
        cancel: "ยกเลิก",
        confirm: "ลบ",
        },
        dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // ส่งคำร้องขอ AJAX ไปยังไฟล์ PHP เพื่อลบข้อมูลในฐานข้อมูล
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "Pro_DeleteGallery.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // กระบวนการที่คุณต้องการทำหลังจากลบข้อมูลสำเร็จ
                    // เช่น รีเฟรชหน้าเว็บ โหลดข้อมูลใหม่ เป็นต้น
                    }
                };
                xhr.send("imageID=" + name);
                imagePreview.remove();
            }
        });
    });

    // Append the delete button to the preview container
    imagePreview.appendChild(deleteButton);

    imageContainer.appendChild(imagePreview);
  });
}

// Call the function to display images from the database
displayImagesFromDatabase();
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/adminlte.min.js"></script>
<?php include("Ma_Footer_Script.php"); ?>