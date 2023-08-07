<?php 
include("DB_Include.php");
include("DB_Setup.php");
?>
<?php  include("Ma_Head_Link.php"); ?>
<?php  include("Ma_Head.php"); ?>
<?php  include("Ma_Carousel.php"); ?>
    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">News & Activities</h6>
                <h2 class="mb-4">ข่าวสารและกิจกรรม</h2>
            </div>

            <?php
                $sql = "SELECT * FROM `Activities` WHERE `Activities`.`AT_Entity No.` = 1 ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC LIMIT 0,6";
                $result = $conn->query($sql);
                $isFirstRow = true;
                $isTwoRow = false;
                $isLastRow = false;
                $counter = 0;
                $row_count = $result->num_rows;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row["AT_Image"] !== '') {
                            $AT_Image = $row["AT_Image"];
                        } else {
                            $AT_Image = $DefaultImageNews;
                        }
                        $counter++;
                        if ($isFirstRow) {
            ?>
            <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
                <div class="container about px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-4 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 300px;">
                            <div class="position-relative h-100">
                                <a href="<?= $PathFolderNews.$AT_Image;?>" data-lightbox="portfolio"> 
                                <img class="position-absolute img-fluid w-100 h-100" src="<?= $PathFolderNews.$AT_Image;?>"
                                    style="object-fit: cover;" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                            <div class="p-lg-5 pe-lg-0">
                                <h6 class="text-primary">NEWS</h6>
                                <h3 class="mb-4"><?= $row['AT_Title'];?></h3>
                                <p><?= $row['AT_Description'];?></p>
                                <a href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>" class="btn btn-primary rounded-pill py-3 px-5 mt-3">อ่านเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                            $isFirstRow = false;
                            $isTwoRow = true;
                            } else {
                                if ($counter !== $row_count) {
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
                            <img class="img-fluid w-100" src="<?= $PathFolderNews.$AT_Image;?>" style="height:250px;" alt="">
                            <div class="portfolio-btn">
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="<?= $PathFolderNews.$AT_Image;?>"
                                    data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>"><i
                                        class="fa fa-link"></i></a>
                            </div>
                        </div>
                        <div class="position-relative p-4 pt-0">
                            <div class="service-icon">
                                <i class="fa fa-newspaper fa-3x"></i>
                            </div>
                            <h4 class="mb-3"><?= $row['AT_Title'];?></h4>
                            <p class=""><?= $row['AT_Description'];?></p>
                            <a class="small fw-medium" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Loop -->
            <?php
                                } else {
            ?>
            </div>
            <div class="row g-1">
                <div class="wow fadeInUp portfolio-item first my-4" data-wow-delay="0.6s">
                    <div align="right">
                        <a class="small fw-medium" href="Ui_List.php?Send_Category=1">ข่าวสารและกิจกรรมทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>  
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
    
<?php // include("Error/Test.php"); ?>
    
<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
<?php include("Ma_Footer_Script.php"); ?>