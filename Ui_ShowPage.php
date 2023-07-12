<!-- PHP -->
<?php 
    include("DB_Include.php");
    if (isset($_GET['Send_Category']) && $_GET['Send_Category'] !== '') {
        $Category_id = $_GET['Send_Category'];
      } else {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = 'ไม่พบหมวดหมู่เอกสารนี้';
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
                $sql = "SELECT * FROM `Category` WHERE `Category`.`CG_Entity No.` = $Category_id;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $DescriptionTH = $row["CG_DescriptionTH"];
                    $DescriptionEN = $row["CG_DescriptionEN"];
                }
            ?>
                <h6 class="text-primary"><?= $row["CG_DescriptionEN"] ?></h6>
                <h2 class="mb-4"><?= $row["CG_DescriptionTH"] ?></h2>
            </div>
        </div>
        <!-- Projects Start -->
        <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-12 text-center">
                <ul class="list-inline mb-5" id="portfolio-flters">
                    <li class="mx-2 active" data-filter="*">All</li>
                    <li class="mx-2" data-filter=".first">Solar Panels</li>
                    <li class="mx-2" data-filter=".second">Wind Turbines</li>
                    <li class="mx-2" data-filter=".third">Hydropower Plants</li>
                </ul>
            </div>
        </div>
        <div class="row g-4 portfolio-container wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-lg-4 col-md-6 portfolio-item first">
                <div class="portfolio-img rounded overflow-hidden">
                    <img class="img-fluid" src="img/img-600x400-6.jpg" alt="">
                    <div class="portfolio-btn">
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                            href="img/img-600x400-6.jpg" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>
                </div>
                <div class="pt-3">
                    <p class="text-primary mb-0">Solar Panels</p>
                    <hr class="text-primary w-25 my-2">
                    <h5 class="lh-base">We Are pioneers of solar & renewable energy industry</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item second">
                <div class="portfolio-img rounded overflow-hidden">
                    <img class="img-fluid" src="img/img-600x400-5.jpg" alt="">
                    <div class="portfolio-btn">
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                            href="img/img-600x400-5.jpg" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>
                </div>
                <div class="pt-3">
                    <p class="text-primary mb-0">Wind Turbines</p>
                    <hr class="text-primary w-25 my-2">
                    <h5 class="lh-base">We Are pioneers of solar & renewable energy industry</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item third">
                <div class="portfolio-img rounded overflow-hidden">
                    <img class="img-fluid" src="img/img-600x400-4.jpg" alt="">
                    <div class="portfolio-btn">
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                            href="img/img-600x400-4.jpg" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>
                </div>
                <div class="pt-3">
                    <p class="text-primary mb-0">Hydropower Plants</p>
                    <hr class="text-primary w-25 my-2">
                    <h5 class="lh-base">We Are pioneers of solar & renewable energy industry</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item first">
                <div class="portfolio-img rounded overflow-hidden">
                    <img class="img-fluid" src="img/img-600x400-3.jpg" alt="">
                    <div class="portfolio-btn">
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                            href="img/img-600x400-3.jpg" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>
                </div>
                <div class="pt-3">
                    <p class="text-primary mb-0">Solar Panels</p>
                    <hr class="text-primary w-25 my-2">
                    <h5 class="lh-base">We Are pioneers of solar & renewable energy industry</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item second">
                <div class="portfolio-img rounded overflow-hidden">
                    <img class="img-fluid" src="img/img-600x400-2.jpg" alt="">
                    <div class="portfolio-btn">
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                            href="img/img-600x400-2.jpg" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>
                </div>
                <div class="pt-3">
                    <p class="text-primary mb-0">Wind Turbines</p>
                    <hr class="text-primary w-25 my-2">
                    <h5 class="lh-base">We Are pioneers of solar & renewable energy industry</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item third">
                <div class="portfolio-img rounded overflow-hidden">
                    <img class="img-fluid" src="img/img-600x400-1.jpg" alt="">
                    <div class="portfolio-btn">
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                            href="img/img-600x400-1.jpg" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href=""><i
                                class="fa fa-link"></i></a>
                    </div>
                </div>
                <div class="pt-3">
                    <p class="text-primary mb-0">Hydropower Plants</p>
                    <hr class="text-primary w-25 my-2">
                    <h5 class="lh-base">We Are pioneers of solar & renewable energy industry</h5>
                </div>
            </div>
        </div>
        <!-- Projects End -->
    </div>
    <!-- Content -->

<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
<?php include("Ma_Footer_Script.php"); ?>