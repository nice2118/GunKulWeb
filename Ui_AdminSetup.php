<?php 
include("DB_Include.php"); 
include("Fn_RecursiveCategory.php"); 
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
                <h2 class="mb-4">ตั้งค่าและเซ็ตค่าเริ่มต้นระบบ</h2>
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
                                        <h3 class="card-title text-white">Activities</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group my-3">
                                            <label for="inputName">รูปเริ่มต้นของข่าวและกิจกรรม</label>
                                            <div class="container-fluid bg-light overflow-hidden px-lg-0">
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
                                        <div class="form-group my-3">
                                            <label for="PathFolderNews">ที่เก็บที่อยู่รูปข่าว</label>
                                            <input type="text" name="PathFolderNews" value="<?= $PathFolderNews; ?>" class="form-control">
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="PathFolderNews">ที่เก็บแกลลอรี่</label>
                                            <input type="text" name="PathFolderGallery" value="<?= $PathFolderGallery; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Category</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <ul class="todo-list" data-widget="todo-list">
                                            <?php
                                                function renderRow($row,$multiplier) {
                                                    global $conn;
                                            ?>
                                                    <span class="text"><?=$row["CG_Name"]?></span>
                                                    <div class="tools">
                                                        <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlert(<?php echo $row["CG_Entity No."];?>, '<?php echo $row["CG_Name"];?>')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-entityno="<?= $row["CG_Entity No."] ?>" data-entityrelationno="<?= $row["CG_Entity Relation No."] ?>" data-name="<?= $row["CG_Name"] ?>" data-descriptionth="<?= $row["CG_DescriptionTH"] ?>" data-descriptionen="<?= $row["CG_DescriptionEN"] ?>"><i class="fas fa-edit"></i> </button>
                                                    </div>
                                                <?php
                                                    $sql = "SELECT *
                                                            FROM category WHERE `CG_Entity Relation No.` = '{$row["CG_Entity No."]}' 
                                                            ORDER BY `CG_Entity No.`, `CG_Entity Relation No.`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        $multiplier++;
                                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <li class="my-2">
                                                <?php
                                                    for ($i = 1; $i <= $multiplier; $i++) {
                                                        echo '<span class="text"></span><span class="text"></span><span class="text"></span>';
                                                    }
                                                    renderRow($row, $multiplier);
                                                ?>
                                                </li>
                                                <?PHP
                                                        }
                                                    }
                                                    unset($sql);
                                                }
                                                    $sql = "SELECT *
                                                        FROM `category` WHERE `CG_Entity Relation No.` = 0
                                                        ORDER BY `CG_Entity No.`, `CG_Entity Relation No.`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                        echo '<li class="my-2">';
                                                        renderRow($row,0);
                                                        echo '</li>';
                                                        }
                                                    }
                                                    unset($sql);
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-entityno="0" data-entityrelationno="0" data-name="" data-descriptionth="" data-descriptionen=""><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>                                
                            </div>

                            <div class="col-md-6">
                                <div class="card card-danger collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Games and recreational activities</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="form-container">
                                        <?PHP
                                            $sql = "SELECT * FROM SetupGames;";
                                            $result = $conn->query($sql);
                                            
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="form-group">
                                                <textarea name="Games[]" class="form-control border-1 my-2" placeholder="iframe" style="height: 110px;"><?php echo htmlspecialchars($row['GA_Iframe'], ENT_QUOTES); ?></textarea>
                                            </div>
                                        <?PHP
                                                }
                                            }
                                        ?>
                                        </div>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-danger rounded-pill py-2 px-3 add-image-btn text-end" id="deleteButton"><i class="fas fa-trash"></i></button>
                                            <button type="button" class="btn btn-primary rounded-pill py-2 px-3 add-image-btn text-end" id="addButton"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Menu Categories</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="todo-list" data-widget="todo-list">
                                            <?PHP
                                                    $sql = "SELECT * FROM `HeadingCategories` ORDER BY `HC_Code`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <li class="my-2">
                                                    <span class="text"><?=$row["HC_Text"]?></span>
                                                    <div class="tools">
                                                        <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlert(<?php echo $row["CG_Entity No."];?>, '<?php echo $row["CG_Name"];?>')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-entityno="<?= $row["CG_Entity No."] ?>" data-entityrelationno="<?= $row["CG_Entity Relation No."] ?>" data-name="<?= $row["CG_Name"] ?>" data-descriptionth="<?= $row["CG_DescriptionTH"] ?>" data-descriptionen="<?= $row["CG_DescriptionEN"] ?>"><i class="fas fa-edit"></i> </button>
                                                    </div>
                                                </li>
                                            <?PHP
                                                    }
                                                }
                                                unset($sql);
                                            ?>
                                        </ui>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-entityno="0" data-entityrelationno="0" data-name="" data-descriptionth="" data-descriptionen=""><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center text-md-end">
                                <!-- <input type="submit" value="บันทึก" class="btn btn-success rounded-pill py-2 px-3 add-image-btn text-end"> -->
                                <button type="submit" class="btn btn-success rounded-pill py-2 px-5 add-image-btn text-end" id="addButton"><i class="fa fa-save"></i></button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <!-- Content -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="Pro_Add&EditCategory.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <div class="col-3 col-sm-2">
                                <h6 class="text-primary">รหัส</h6>
                                <input type="Text" id="CG_EntityNo" name="CG_EntityNo" class="form-control border-1" placeholder="0" readonly>
                            </div>
                            <div class="col-5 col-sm-5">
                                <h6 class="text-primary">ลำดับชั้นที่จะต่อ</h6>
                                <select class="form-select border-1" id="CG_EntityRelationNo" name="CG_EntityRelationNo">
                                        <option></option>
                                    <?php
                                        $SelectFilterCategoryEntityNo = SearchCategorySub(0);
                                        echo $SelectFilterCategoryEntityNo;
                                        // $sql = "SELECT * FROM `category` WHERE (`CG_Entity No.` IN ($SelectFilterCategoryEntityNo));";
                                        $sql = "SELECT * FROM `category`;";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = ($row["CG_Entity No."] == $CG_EntityRelationNo) ? 'selected' : ''; // เปรียบเทียบกับ $CG_EntityRelationNo ที่ได้มาจากคำสั่งด้านบน
                                    ?>
                                        <option value="<?= $row["CG_Entity No."] ?>" <?= $selected ?>><?= $row["CG_Name"] ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <!-- <input type="Text" id="CG_EntityRelationNo" name="CG_EntityRelationNo" class="form-control border-1" value="" placeholder=""> -->
                                <!-- <input type="number" id="CG_EntityRelationNo" name="CG_EntityRelationNo" class="form-control border-1" value="" placeholder="0" min="0" oninput="this.value = this.value < 0 ? 0 : this.value"> -->
                            </div>
                            <div class="col-5 col-sm-5">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="CG_Name" name="CG_Name" class="form-control border-1" placeholder="ชื่อหัวข้อ" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาไทย</h6>
                                <input type="Text" id="CG_DescriptionTH" name="CG_DescriptionTH" class="form-control border-1" placeholder="ชื่อภาษาไทย" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาอังกฤษ</h6>
                                <input type="Text" id="CG_DescriptionEN" name="CG_DescriptionEN" class="form-control border-1" placeholder="ชื่อภาษาอังกฤษ" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <!-- <button type="button" class="btn btn-primary" onclick="submitModalForm()">บันทึก</button> -->
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("Ma_Footer.php"); ?>
    <script>
        function redirectToPage() {
            // หากต้องการเลื่อนลงมากลางหน้าต่างใหม่ที่เปิด คุณสามารถใช้ตำแหน่ง scrollTop
            // ของหน้าต่างใหม่เท่ากับครึ่งหนึ่งของความสูงของหน้าต่าง
            const windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
            const halfWindowHeight = windowHeight / 2;
            window.scrollTo(0, halfWindowHeight);
        }

        // ให้เรียกใช้ฟังก์ชัน redirectToPage เมื่อโหลดหน้าใหม่
        setTimeout(redirectToPage, 0);
    </script>
    <!-- Show Image -->
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
    <!-- Add & Delete Input -->
    <script>
    $(document).ready(function() {
        var count = 1; // ตัวแปรนับค่าชื่อ name
        $('#addButton').click(function() {
            var formGroup = $('<div class="form-group">' +
                '<textarea name="Games[]" class="form-control border-0 my-2" placeholder="iframe" style="height: 110px;"></textarea>' +
                '</div>');
            $('#form-container').append(formGroup);
        });

        $('#deleteButton').click(function() {
            $('#form-container .form-group:last-child').remove();
            count--; // ลดค่านับเมื่อกดปุ่ม "ลบ"
        });
    });
    </script>
        <!-- category Delete -->
    <script>
        function deleteAlert(categoryID, categoryName) {
            swal({
                title: "คุณต้องการที่จะลบหรือไม่?",
                text: `${categoryName}\nเมื่อกดลบไปแล้วข่าวและกิจกรรมนี้จะไม่สามารถนำข้อมูลกลับมาได้!`,
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "ยกเลิก",
                        value: false,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                    confirm: {
                        text: "ลบ",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true,
                    },
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                    window.location.replace(`Pro_DeleteCategory.php?Send_ID=${categoryID}&Send_Name=${categoryName}`);
                } else {
                    // เมื่อกดยกเลิก ไม่ต้องทำอะไร
                }
            })
            .catch((error) => {
                // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
                console.error("Error displaying SweetAlert:", error);
            });
        }
        
            // ตรวจสอบว่ามีข้อความใน Session หรือไม่
        <?php if (isset($_SESSION['StatusMessage'])) : ?>
            // แสดงข้อความแจ้งเตือนเมื่อโหลดหน้า
            window.onload = function() {
                swal("<?php echo $_SESSION['StatusTitle']; ?>", "<?php echo $_SESSION['StatusMessage']; ?>", "<?php echo $_SESSION['StatusAlert']; ?>");
                <?php unset($_SESSION['StatusTitle'], $_SESSION['StatusMessage'], $_SESSION['StatusAlert']); ?> // ลบค่าใน Session เพื่อไม่ให้แสดงซ้ำ
            };
        <?php endif; ?>
    </script>
    <!-- category Edit -->
    <script>
    // JavaScript
    function saveData() {
        const entityNo = document.getElementById("CG_EntityNo").value;
        const entityRelationNo = document.getElementById("CG_EntityRelationNo").value;
        const name = document.getElementById("CG_Name").value;
        const descriptionTH = document.getElementById("CG_DescriptionTH").value;
        const descriptionEN = document.getElementById("CG_DescriptionEN").value;

        // ใช้ตัวแปรนี้ในการทำงานต่อ
        console.log("Entity No:", entityNo);
        console.log("Entity Relation No:", entityRelationNo);
        console.log("Name:", name);
        console.log("Description (TH):", descriptionTH);
        console.log("Description (EN):", descriptionEN);
    }

    // เมื่อ Modal ถูกเปิดขึ้นมา
    $('#staticBackdrop').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const entityNo = button.data('entityno');
        const entityRelationNo = button.data('entityrelationno');
        const name = button.data('name');
        const descriptionTH = button.data('descriptionth');
        const descriptionEN = button.data('descriptionen');

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("CG_EntityNo").value = entityNo;
        document.getElementById("CG_EntityRelationNo").value = entityRelationNo;
        document.getElementById("CG_Name").value = name;
        document.getElementById("CG_DescriptionTH").value = descriptionTH;
        document.getElementById("CG_DescriptionEN").value = descriptionEN;
    });
    </script>
<?php include("Ma_Footer_Script.php"); ?>