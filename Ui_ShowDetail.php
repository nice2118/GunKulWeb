<!-- PHP -->
<?php 
    include("DB_Include.php");
    include("DB_Setup.php");
    if (isset($_GET['Send_IDNews']) && $_GET['Send_IDNews'] !== '') {
        $t_id = $_GET['Send_IDNews'];
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
<?php include("Ma_Head_Link.php"); ?>
<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <?php
                $sql = "SELECT * FROM `Activities` LEFT JOIN `Category` ON `Activities`.`AT_Entity No.` = `Category`.`CG_Entity No.` WHERE `Activities`.`AT_Code` = $t_id;";     
                $result = $conn->query($sql);        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
            ?>
                <h3 class="text-primary"><?= $row["CG_DescriptionEN"] ?></h3>
                <h2 class="mb-4"><?= $row["CG_DescriptionTH"] ?></h2>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded overflow-hidden">
                    <!-- <div class="container-fluid bg-light2 overflow-hidden my-3 px-lg-0"> -->
                        <div class="container quote px-lg-0">
                            <div class="row g-0 mx-lg-0 py-5">
                                <?php
                    $decodedText = base64_decode($row["AT_Note"]);
                    if ($decodedText !== false) {
                        echo $decodedText;
                    } else {
                        echo $row["AT_Note"];
                    }
                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $sql = "SELECT * FROM `gallery` WHERE `gallery`.`GR_Activities Code` = '$t_id' ORDER BY `gallery`.`GR_CreateDate` DESC";
                    // $sql = "SELECT * FROM `gallery` ORDER BY `gallery`.`GR_CreateDate` DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                ?>
                <div class="col-md-12">
                    <div class="card card-primary collapsed-card">
                    <!-- <div class="card card-primary"> -->
                        <div class="card-header">
                            <h3 class="card-title text-white">แกลลอรี่</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row g-4">
                            <?php
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                <div class="col-lg-2 col-md-2 portfolio-item">
                                    <div class="portfolio-img rounded overflow-hidden">
                                        <?php if (strpos($row["GR_Name"], '.mp4') !== false || strpos($row["GR_Name"], '.avi') !== false || strpos($row["GR_Name"], '.wmv') !== false): ?>
                                            <!-- ถ้าเป็นไฟล์วิดีโอ (.mp4) -->
                                            <video class="img-fluid img-size w-100" style="height: 150px;" autoplay muted>
                                                <source src="<?= $PathFolderGallery . $row["GR_Name"] ?>" type="video/mp4">
                                            </video>
                                            <div class="portfolio-btn">
                                                <button class="btn btn-lg-square btn-outline-light rounded-circle mx-1" data-bs-toggle="modal" data-bs-target="#videoModal"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                <div class="embed-responsive-item">
                                                                    <div class="video-container text-center">
                                                                        <iframe src="<?= $PathFolderGallery . $row["GR_Name"] ?>" allowfullscreen autoplay muted></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- ถ้าเป็นไฟล์รูปภาพ -->
                                            <img class="img-fluid img-size w-100" src="<?= $PathFolderGallery . $row["GR_Name"] ?>" style="height: 150px;" alt="">
                                            <div class="portfolio-btn">
                                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="<?= $PathFolderGallery.$row["GR_Name"];?>" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Content -->

<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
<script src="js/jquery.min.js"></script>
<script src="js/adminlte.min.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: "DB_CountPage.php",
        type: "POST",
        data: { Type: 'activities', Code: <?=$t_id?> },
        dataType: "json",
        success: function(response) {
            console.log("Data sent successfully:", response);
        },
        error: function() {
            console.log("Error occurred");
        }
    });
});
</script>
<?php include("Ma_Footer_Script.php"); ?>