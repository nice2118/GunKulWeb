<?php 
include("DB_Include.php");
include("DB_Setup.php");
$Category1_id = 1;
$Category2_id = 19;
$Category3_id = 0;
?>
<?php  include("Ma_Head_Link.php"); ?>
<?php  include("Ma_Head.php"); ?>
<?php  include("Ma_Carousel.php"); ?>
    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <?php
                    $sql = "SELECT * FROM `Category` WHERE `Category`.`CG_Entity No.` = $Category1_id;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $DescriptionTHGroup1 = $row["CG_DescriptionTH"];
                        $DescriptionENGroup1 = $row["CG_DescriptionEN"];
                        $IsTypeGroup1 = $row["CG_IsFile"];
                    }
                ?>
                <h6 class="text-primary"><?= $DescriptionENGroup1 ?></h6>
                <h2 class="mb-4"><?= $DescriptionTHGroup1 ?></h2>
            </div>
            <?php
                if ($IsTypeGroup1 == 0):
                    $sql = "SELECT * FROM `Activities` WHERE `Activities`.`AT_Entity No.` = $Category1_id ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC LIMIT 0,5";
                elseif ($IsTypeGroup1 == 1):
                    $sql = "SELECT * FROM `FileActivities` WHERE `FileActivities`.`FA_Entity No.` = $Category1_id ORDER BY `FileActivities`.`FA_Date` DESC , `FileActivities`.`FA_Time` DESC LIMIT 0,5";
                endif;
                $result = $conn->query($sql);
                $isFirstRow = true;
                $isTwoRow = false;
                $isLastRow = false;
                $counter = 0;
                $row_count = $result->num_rows;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($IsTypeGroup1 == 0) {
                            $index1Code = $row["AT_Code"];
                            $index1Image = $row["AT_Image"];
                        } elseif ($IsTypeGroup1 == 1) {
                            $index1Code = $row["FA_Code"];
                            $index1Image = $row["FA_Image"];
                        } else {
                            $index1Code = "";
                            $index1Image = "";
                        }
                        if ($index1Image !== '') {
                            $AT_Image = $PathFolderNews.$index1Image;
                        } else {
                            $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` = $Category1_id;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                if ($row['CG_DefaultImage'] !== '') {
                                    $AT_Image = 'img/DefaultImageCategory/'.$row['CG_DefaultImage'];
                                } else {
                                    $AT_Image = $PathFolderNews.$DefaultImageNews;
                                }
                            }
                        }
                        $counter++;
                        if ($isFirstRow) {
            ?>
            <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
                <div class="container about px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-4 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 300px;">
                            <div class="position-relative h-100">
                                <a href="<?= $AT_Image;?>" data-lightbox="portfolio"> 
                                <img class="position-absolute img-fluid w-100 h-100" src="<?= $AT_Image;?>"
                                    style="object-fit: cover;" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                            <div class="p-lg-5 pe-lg-0">
                                <h6 class="text-primary">NEWS</h6>
                                <h3 class="mb-4"><?= $row['AT_Title'];?></h3>
                                <p><?= $row['AT_Description'];?></p>
                                <a href="Ui_ShowDetail.php?Send_IDNews=<?= $index1Code;?>" class="btn btn-primary rounded-pill py-3 px-5 mt-3">อ่านเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                            $isFirstRow = false;
                            $isTwoRow = true;
                            } else {
                                if ($isTwoRow) {
                                    $isTwoRow = false;
            ?>
            <div class="row g-4">
            <?php
                                }
            ?>
                <!-- Loop -->
                <div class="col-lg-3 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="service-item rounded overflow-hidden">
                        <div class="portfolio-img rounded overflow-hidden">
                            <img class="img-fluid w-100" src="<?= $AT_Image;?>" style="height:280px;" alt="">
                            <div class="portfolio-btn">
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="<?= $$AT_Image;?>"
                                    data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>"><i
                                        class="fa fa-link"></i></a>
                            </div>
                        </div>
                        <div class="position-relative p-4 pt-0">
                            <div class="service-icon">
                                <i class="fa fa-newspaper fa-3x"></i>
                            </div>
                            <h4 class="mb-3"><?= $row['AT_Title'] ?></h4>
                            <p class=""><?= $row['AT_Description'] ?></p>

                            <a class="small fw-medium" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Loop -->
            <?php
                                    // $counter++;
                                if ($counter == $row_count) {
            ?>
            </div>
            <div class="row g-1">
                <div class="wow fadeInUp portfolio-item first my-4" data-wow-delay="0.6s">
                    <div align="right">
                        <a class="small fw-medium" href="Ui_List.php?Send_Category=<?= $Category1_id ?>"><?= $DescriptionTHGroup1 ?>ทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>  
                    </div>
                </div>
            </div>
            <?php
                                }     
                            }
                        }
                    }
            ?>
        </div>
    </div>
    <!-- Content -->
    <!-- Content 2 -->
    <?php if ($Category2_id !== 0 && $Category2_id !== '') { ?>
    <div class="container-xxl py-2">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <?php
                    $sql = "SELECT * FROM `Category` WHERE `Category`.`CG_Entity No.` = $Category2_id;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $DescriptionTHGroup2 = $row["CG_DescriptionTH"];
                        $DescriptionENGroup2 = $row["CG_DescriptionEN"];
                        $IsTypeGroup2 = $row["CG_IsFile"];
                    }
                ?>
                <h6 class="text-primary"><?= $DescriptionENGroup2 ?></h6>
                <h2 class="mb-4"><?= $DescriptionTHGroup2 ?></h2>
            </div>

            <?php
                if ($IsTypeGroup2 == 0):
                    $sql = "SELECT * FROM `Activities` WHERE `Activities`.`AT_Entity No.` = $Category2_id ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC LIMIT 0,5";
                elseif ($IsTypeGroup2 == 1):
                    $sql = "SELECT * FROM `FileActivities` WHERE `FileActivities`.`FA_Entity No.` = $Category2_id ORDER BY `FileActivities`.`FA_Date` DESC , `FileActivities`.`FA_Time` DESC LIMIT 0,5";
                endif;
                $result = $conn->query($sql);
                $isFirstRow = true;
                $isTwoRow = false;
                $isLastRow = false;
                $counter = 0;
                $row_count = $result->num_rows;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($IsTypeGroup2 == 0) {
                            $index2Code = $row["AT_Code"];
                            $index2Image = $row["AT_Image"];
                        } elseif ($IsTypeGroup2 == 1) {
                            $index2Code = $row["FA_Code"];
                            $index2Image = $row["FA_Image"];
                        } else {
                            $index2Code = "";
                            $index2Image = "";
                        }
                        if ($index2Image !== '') {
                            $AT_Image = $PathFolderNews.$index2Image;
                        } else {
                            $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` = $Category2_id;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                if ($row['CG_DefaultImage'] !== '') {
                                    $AT_Image = 'img/DefaultImageCategory/'.$row['CG_DefaultImage'];
                                } else {
                                    $AT_Image = $PathFolderNews.$DefaultImageNews;
                                }
                            }
                        }
                        $counter++;
                        if ($isFirstRow) {
            ?>
            <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
                <div class="container about px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-4 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 300px;">
                            <div class="position-relative h-100">
                                <a href="<?= $AT_Image;?>" data-lightbox="portfolio"> 
                                <img class="position-absolute img-fluid w-100 h-100" src="<?= $AT_Image;?>"
                                    style="object-fit: cover;" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                            <div class="p-lg-5 pe-lg-0">
                                <h6 class="text-primary">NEWS</h6>
                                <h3 class="mb-4"><?= $row['AT_Title'];?></h3>
                                <p><?= $row['AT_Description'];?></p>
                                <a href="Ui_ShowDetail.php?Send_IDNews=<?= $index2Code;?>" class="btn btn-primary rounded-pill py-3 px-5 mt-3">อ่านเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                            $isFirstRow = false;
                            $isTwoRow = true;
                            } else {
                                if ($isTwoRow) {
                                    $isTwoRow = false;
            ?>
            <div class="row g-4">
            <?php
                                }
            ?>
                <!-- Loop -->
                <div class="col-lg-3 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="service-item rounded overflow-hidden">
                        <div class="portfolio-img rounded overflow-hidden">
                            <img class="img-fluid w-100" src="<?= $AT_Image;?>" style="height:280px;" alt="">
                            <div class="portfolio-btn">
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="<?= $AT_Image;?>"
                                    data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>"><i
                                        class="fa fa-link"></i></a>
                            </div>
                        </div>
                        <div class="position-relative p-4 pt-0">
                            <div class="service-icon">
                                <i class="fa fa-newspaper fa-3x"></i>
                            </div>
                            <h4 class="mb-3"><?= $row['AT_Title'] ?></h4>
                            <p class=""><?= $row['AT_Description'] ?></p>

                            <a class="small fw-medium" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Loop -->
            <?php
                                    // $counter++;
                                if ($counter == $row_count) {
            ?>
            </div>
            <div class="row g-1">
                <div class="wow fadeInUp portfolio-item first my-4" data-wow-delay="0.6s">
                    <div align="right">
                        <a class="small fw-medium" href="Ui_List.php?Send_Category=<?= $Category2_id ?>"><?= $DescriptionTHGroup2 ?>ทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>  
                    </div>
                </div>
            </div>
            <?php
                                }     
                            }
                        }
                    }
            ?>
        </div>
    </div>
    <?php } ?>
    <!-- Content 2 -->
    <!-- Team Start -->
    <?php if ($Category3_id !== 0 && $Category3_id !== '') { ?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h3 class="text-primary">Common Menu</h3>
                <h1 class="mb-4">เมนูทั่วไป</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item rounded overflow-hidden">
                        <a class="small fw-medium" href="#">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="Default/DefaultImage/DefaultImage.png" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item rounded overflow-hidden">
                        <a class="small fw-medium" href="#">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="Default/DefaultImage/DefaultImage.png" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item rounded overflow-hidden">
                        <a class="small fw-medium" href="#">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="Default/DefaultImage/DefaultImage.png" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item rounded overflow-hidden">
                        <a class="small fw-medium" href="#">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="Default/DefaultImage/DefaultImage.png" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5>Full Name</h5>
                                <span>Designation</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- Team End -->
    
<?php // include("Error/Test.php"); ?>
    
<?php include("Ma_Footer.php"); ?>
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
<?php include("Ma_FirstFooter_Script.php"); ?>
<!-- เก็บประวัติการเข้าใช้งาน -->
<script>
$(document).ready(function() {
    $.ajax({
        url: "DB_CountPage.php",
        type: "POST",
        data: { Type: 'setup', Code: 1 },
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