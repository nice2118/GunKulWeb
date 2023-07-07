<?php 
include("DB_Include.php");
include("DB_Setup.php");
?>
<?php include("Head_Link.php"); ?>
<?php include("Head.php"); ?>
<?php include("Carousel.php"); ?>
    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">News & Activities</h6>
                <h1 class="mb-4">ข่าวสารและกิจกรรม</h1>
            </div>

            <?php
                $sql = "SELECT * FROM `Activities` ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
            ?>
            <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0">
                <div class="container about px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-6 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                            <div class="position-relative h-100">
                                <a href="<?= $PathFolderNews.$row['AT_Image'];?>" data-lightbox="portfolio"> 
                                <img class="position-absolute img-fluid w-100 h-100" src="<?= $PathFolderNews.$row['AT_Image'];?>"
                                    style="object-fit: cover;" alt="">
                                </a>
                            </div>
                        </div>
                      
                        <div class="col-lg-6 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                            <div class="p-lg-5 pe-lg-0">
                                <h6 class="text-primary">NEWS</h6>
                                <h3 class="mb-4"><?= $row['AT_Title'];?></h3>
                                <p><?= $row['AT_Description'];?></p>
                                <a href="News_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>" class="btn btn-primary rounded-pill py-3 px-5 mt-3">อ่านเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php        
                }
            ?>
            

            <div class="row g-4">
                <!-- Loop 6 -->
                <?php
                    $sql = "SELECT * FROM `Activities` ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC LIMIT 1,6";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        
                ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="service-item rounded overflow-hidden">
                        <div class="portfolio-img rounded overflow-hidden">
                            <img class="img-fluid w-100" src="<?= $PathFolderNews.$row['AT_Image'];?>" style="height:275px;" alt="">
                            <div class="portfolio-btn">
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="<?= $PathFolderNews.$row['AT_Image'];?>"
                                    data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="News_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>"><i
                                        class="fa fa-link"></i></a>
                            </div>
                        </div>
                        <div class="position-relative p-4 pt-0">
                            <div class="service-icon">
                                <i class="fa fa-newspaper fa-3x"></i>
                            </div>
                            <h4 class="mb-3"><?= $row['AT_Title'];?></h4>
                            <p class=""><?= $row['AT_Description'];?></p>
                            <a class="small fw-medium" href="News_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <?php        
                        }
                    }
                ?>
                <!-- <div class="col-lg-4 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="portfolio-img rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/3.png" style="height:275px;" alt="">
                        <img class="img-fluid w-100 h-100" src="img/3.png" alt=""> 
                        <div class="portfolio-btn">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="img/3.png"
                                data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                    class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="position-relative p-4 pt-0">
                        <div class="service-icon">
                            <i class="fa fa-newspaper fa-3x"></i>
                        </div>
                        <h4 class="mb-3">Solar Panels</h4>
                        <p class="">Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>
                        <a class="small fw-medium" href="">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="portfolio-img rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/8.jpg" style="height:275px;" alt="">
                        <div class="portfolio-btn">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="img/8.jpg"
                                data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                    class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="position-relative p-4 pt-0">
                        <div class="service-icon">
                            <i class="fa fa-newspaper fa-3x"></i>
                        </div>
                        <h4 class="mb-3">Solar Panels</h4>
                        <p class="">Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>
                        <a class="small fw-medium" href="">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="portfolio-img rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/5.png" style="height:275px;" alt="">
                        <div class="portfolio-btn">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                                href="img/5.png" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                    class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="position-relative p-4 pt-0">
                        <div class="service-icon">
                            <i class="fa fa-newspaper fa-3x"></i>
                        </div>
                        <h4 class="mb-3">Solar Panels</h4>
                        <p class="">Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>
                        <a class="small fw-medium" href="">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="portfolio-img rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/6.png" style="height:275px;" alt="">
                        <div class="portfolio-btn">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="img/6.png"
                                data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                    class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="position-relative p-4 pt-0">
                        <div class="service-icon">
                            <i class="fa fa-newspaper fa-3x"></i>
                        </div>
                        <h4 class="mb-3">Solar Panels</h4>
                        <p class="">Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>
                        <a class="small fw-medium" href="">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp portfolio-item first" data-wow-delay="0.1s">
                    <div class="portfolio-img rounded overflow-hidden">
                        <img class="img-fluid w-100" src="img/7.jpg" style="height:275px;" alt="">
                        <div class="portfolio-btn">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="img/7.jpg"
                                data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                    class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="position-relative p-4 pt-0">
                        <div class="service-icon">
                            <i class="fa fa-newspaper fa-3x"></i>
                        </div>
                        <h4 class="mb-3">Solar Panels</h4>
                        <p class="">Stet stet justo dolor sed duo. Ut clita sea sit ipsum diam lorem diam.</p>
                        <a class="small fw-medium" href="">อ่านเพิ่มเติม<i class="fa fa-arrow-right ms-2"></i></a>
                    </div>
                </div> -->
                <!-- Loop 6 -->
            </div>
            <div class="row g-1">
                <div class="wow fadeInUp portfolio-item first" data-wow-delay="0.6s">
                    <div align="right">
                        <a class="small fw-medium" href="News_List.php">ข่าวสารและกิจกรรมทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content -->
    
<?php include("Error/Test.php"); ?>
    
<?php include("Footer.php"); ?>
<?php include("FirstFooter_Script.php"); ?>
<?php include("Footer_Script.php"); ?>