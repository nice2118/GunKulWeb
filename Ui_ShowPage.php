<!-- PHP -->
<?php 
    include("DB_Include.php");
    include("DB_Setup.php");
    if (isset($_REQUEST['Send_Category']) && $_REQUEST['Send_Category'] !== '') {
        $Category_id = $_REQUEST['Send_Category'];
        $Multiplier = $_REQUEST['Multiplier'];
        $Search = $_REQUEST['Search'];
        $Maxbox = 24 * $Multiplier;     // 24 มาจากแสดงเริ่มต้น
        $countSql = 0;
        $_SESSION['PathPage'] = "Ui_ShowPage.php?Send_Category=$Category_id&Multiplier=$Multiplier";
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
<?php include("Fn_RecursiveCategory.php"); ?>
<?php include("Ma_Head_Link.php"); ?>
    <script>
        function scrollToBottom() {
            // หาความสูงของเนื้อหาในหน้าต่างที่เปิด (สูงสุด)
            const contentHeight = Math.max(
                document.body.scrollHeight,
                document.body.offsetHeight,
                document.documentElement.clientHeight,
                document.documentElement.scrollHeight,
                document.documentElement.offsetHeight
            );

            // เลื่อนหน้าเว็บไปที่ส่วนล่างสุดของเนื้อหา
            window.scrollTo(0, contentHeight);
        }

        // ถ้าค่า $CG_EntityNo และ $CG_EntityRelationNo ไม่ใช่ 0 ให้เลื่อนลงมากลางหน้าต่างทันที
        <?php if ($Multiplier > 1 ) { ?>
            window.onload = scrollToBottom;
            scrollToBottom();
        <?php } ?>
    </script>
<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0"></div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                        <form action="Ui_ShowPage.php" method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-4 col-sm-6"></div>
                                <div class="col-8 col-sm-6 d-flex">
                                    <button type="submit" class="btn btn-white py-1 px-lg-1 me-1"><i class="fa fa-search fs-5"></i></button>
                                    <input type="text" class="form-control border-0" name="Search" placeholder="ค้นหาชื่อ...">
                                </div>
                                <input type="hidden" name="Send_Category" value="<?= $Category_id ?>">
                                <input type="hidden" name="Multiplier" value="100">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                <h6 class="text-primary"><?= $DescriptionEN ?></h6>
                <h2 class="mb-4"><?= $DescriptionTH ?></h2>
            </div>
        </div>
        <!-- Projects Start -->
        <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-12 text-center">
                <ul class="list-inline mb-5" id="portfolio-flters">
                    <?php
                        $SelectFilterCategoryEntityNo = SearchCategorySubNotHeader($Category_id);
                        if (!empty($SelectFilterCategoryEntityNo)) {
                    ?>
                    <li class="mx-2 active" data-filter="*">All</li>
                    <?php
                            $sql = "SELECT * FROM `category` WHERE (`CG_Entity No.` IN ($SelectFilterCategoryEntityNo));";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                    ?>
                    <li class="mx-2" data-filter=".<?= $row["CG_Entity No."] ?>"><?= $row["CG_DescriptionTH"] ?></li>
                    <?php
                                }
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row g-4 portfolio-container wow fadeInUp" data-wow-delay="0.5s">
        <?php
            $SelectFilterCategoryEntityNoTotal = SearchCategory($Category_id);
            $sql = "SELECT * FROM `Activities` 
            LEFT JOIN user ON `Activities`.AT_UserCreate = User.US_Username 
            LEFT JOIN `Category` ON `Activities`.`AT_Entity No.` = `Category`.`CG_Entity No.` 
            WHERE (`Activities`.`AT_Entity No.` IN ($SelectFilterCategoryEntityNoTotal)) 
            AND (`Activities`.`AT_Title` LIKE '%$Search%') -- เพิ่มเงื่อนไขการค้นหาใน AT_Title
            ORDER BY `Activities`.`AT_Date` DESC, `Activities`.`AT_Time` DESC";
            $result = $conn->query($sql);
            $countSql = $result->num_rows;
            
            $sql .= " LIMIT 0, $Maxbox;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row["AT_Image"] !== '') {
                        $AT_Image = $row["AT_Image"];
                    } else {
                        $AT_Image = $DefaultImageNews;
                    }
        ?>
            <div id="portfolio-container" class="row">
                <div class="col-lg-3 col-md-4 portfolio-item <?= SearchCategoryReturnNotBegin($row['AT_Entity No.']) ?>" style="min-height: 400px;">
                    <div class="portfolio-img rounded overflow-hidden">
                        <img class="img-fluid w-100" src="<?= $PathFolderNews.$AT_Image;?>" style="height:275px;" alt="">
                        <div class="portfolio-btn">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1"
                                href="<?= $PathFolderNews.$AT_Image;?>" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-lg-square btn-outline-light rounded-circle mx-1" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>"><i
                                    class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="pt-3">
                        <p class="text-primary mb-0"><?= $row['CG_DescriptionTH'];?></p>
                        <hr class="text-primary w-25 my-2">
                        <h5 class="lh-base"><?= $row['AT_Title'];?></h5>
                    </div>
                </div>
            </div>
        <?php
                }
            }
        ?>
        </div>
        <!-- Projects End -->
        <div class="row g-1">
            <div class="wow fadeInUp portfolio-item first my-4" data-wow-delay="0.6s">
                <div align="right">
                    <a class="small fw-medium" href="Ui_List.php?Send_Category=<?= $Category_id ?>"><?= $DescriptionTH ?>ทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>  
                </div>
            </div>
        </div>
        <?php
            if ($countSql > $Maxbox) {
        ?>
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <a href="Ui_ShowPage.php?Send_Category=<?= $Category_id ?>&Multiplier=<?= $Multiplier + 1 ?>&Search=" class="btn btn-primary rounded-pill py-3 px-5 mt-3">แสดงเพิ่มเติม</a>
            </div>
        </div>
        <?php
            }
        ?>
    </div>
    <!-- Content -->

<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
<?php include("Ma_Footer_Script.php"); ?>