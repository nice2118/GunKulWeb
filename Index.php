<?php 
include("DB_Include.php");
include("DB_Setup.php");
include("Fn_RecursiveCategory.php");
$Category1_id = 0;
$Category2_id = 0;
$Category3_id = 0;
$Category3 = '';
$Category4_id = 0;
$Category4 = '';
$Category5_id = 0;
$Category5 = '';
$Category6_id = 0;
$Category6 = '';
$sql = "SELECT * FROM `indexsetup`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Category1_id = $row["IS_GroupCategory1"];
    $Category2_id = $row["IS_GroupCategory2"];
    $Category3_id = $row["IS_GroupMenu1_Box1"];
    $Category3 = $row["IS_GroupMenu1"];
    $Category4_id = $row["IS_GroupMenu2_Box2"];
    $Category4 = $row["IS_GroupMenu2"];
    $Category5_id = $row["IS_GroupMenu3_Box3"];
    $Category5 = $row["IS_GroupMenu3"];
    $Category6_id = $row["IS_GroupMenu4_Box4"];
    $Category6 = $row["IS_GroupMenu4"];
}
?>
<?php  include("Ma_Head_Link.php"); ?>
<?php  include("Ma_Head.php"); ?>
<?php  include("Ma_Carousel.php"); ?>
    <div id="popupModal"></div>
    <!-- Content -->
    <?php if ($Category1_id !== 0 && $Category1_id !== '') { ?>
    <div class="container-xxl2 py-5">
        <div class="container2">
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
                <h3 class="text-primary"><?= $DescriptionENGroup1 ?></h3>
                <h2 class="mb-4"><?= $DescriptionTHGroup1 ?></h2>
            </div>
            <?php
                $SelectFilterCategoryEntityNoTotal1 = SearchCategory($Category1_id);
                if ($IsTypeGroup1 == 0):
                    $sql = "SELECT * FROM `Activities` WHERE `Activities`.`AT_Entity No.` IN ($SelectFilterCategoryEntityNoTotal1) ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC LIMIT 0,5";
                elseif ($IsTypeGroup1 == 1):
                    $sql = "SELECT * FROM `FileActivities` WHERE `FileActivities`.`FA_Entity No.` IN ($SelectFilterCategoryEntityNoTotal1) ORDER BY `FileActivities`.`FA_Date` DESC , `FileActivities`.`FA_Time` DESC LIMIT 0,5";
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
            <div class="container-fluid2 bg-light overflow-hidden my-5 px-lg-0">
                <div class="container2 about px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-4 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 300px;">
                            <div class="position-relative h-100">
                                <a href="<?= $AT_Image;?>" data-lightbox="portfolio"> 
                                <img class="position-absolute img-fluid2 w-100 h-100" src="<?= $AT_Image;?>"
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
                    <div class="service-item2 rounded overflow-hidden">
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
                        <?php if ($IsTypeGroup1 == 0): ?>
                            <a class="small fw-medium" href="Ui_ShowPage.php?Send_Category=<?= $Category1_id ?>&Multiplier=1&Search="><?= $DescriptionTHGroup1 ?>ทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>
                        <?php elseif ($IsTypeGroup1 == 1): ?>
                            <a class="small fw-medium" href="Ui_List.php?Send_Category=<?= $Category1_id ?>"><?= $DescriptionTHGroup1 ?>ทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>
                        <?php endif; ?>  
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
    <!-- Content -->
    
    <!-- Content 2 -->
    <?php if ($Category2_id !== 0 && $Category2_id !== '') { ?>
    <div class="container-xxl2 py-2">
        <div class="container2">
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
                <h3 class="text-primary"><?= $DescriptionENGroup2 ?></h3>
                <h2 class="mb-4"><?= $DescriptionTHGroup2 ?></h2>
            </div>

            <?php
                $SelectFilterCategoryEntityNoTotal2 = SearchCategory($Category2_id);
                if ($IsTypeGroup2 == 0):
                    $sql = "SELECT * FROM `Activities` WHERE `Activities`.`AT_Entity No.` IN ($SelectFilterCategoryEntityNoTotal2) ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC LIMIT 0,5";
                elseif ($IsTypeGroup2 == 1):
                    $sql = "SELECT * FROM `FileActivities` WHERE `FileActivities`.`FA_Entity No.` IN ($SelectFilterCategoryEntityNoTotal2) ORDER BY `FileActivities`.`FA_Date` DESC , `FileActivities`.`FA_Time` DESC LIMIT 0,5";
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
            <div class="container-fluid2 bg-light overflow-hidden my-5 px-lg-0">
                <div class="container2 about px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-4 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 300px;">
                            <div class="position-relative h-100">
                                <a href="<?= $AT_Image;?>" data-lightbox="portfolio"> 
                                <img class="position-absolute img-fluid2 w-100 h-100" src="<?= $AT_Image;?>"
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
                    <div class="service-item3 rounded overflow-hidden">
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
                        <?php if ($IsTypeGroup1 == 0): ?>
                            <a class="small fw-medium" href="Ui_ShowPage.php?Send_Category=<?= $Category2_id ?>&Multiplier=1&Search="><?= $DescriptionTHGroup2 ?>ทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>
                        <?php elseif ($IsTypeGroup1 == 1): ?>
                            <a class="small fw-medium" href="Ui_List.php?Send_Category=<?= $Category2_id ?>"><?= $DescriptionTHGroup2 ?>ทั้งหมด<i class="fa fa-arrow-right ms-2"></i></a>
                        <?php endif; ?> 
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
    <?php if ($Category3_id !== 0 && $Category4_id !== 0 && $Category5_id !== 0 && $Category6_id !== 0) { ?>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h3 class="text-primary">Common Menu</h3>
                <h1 class="mb-4">เมนูทั่วไป</h1>
            </div>
            <div class="row g-4">
            <?php if ($Category3_id != 0) { ?>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item2 rounded overflow-hidden">
                    
                    <?php 
                        if ($Category3 === 'category') {
                            $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` = '$Category3_id';";
                        } elseif ($Category3 === 'headingcategories') {
                            $sql = "SELECT * FROM `HeadingCategories` WHERE `HC_Code` = '$Category3_id';";
                        }
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                if ($Category3 === 'category') {
                                    $Name01 = $row['CG_DescriptionTH'];
                                    $Designation01 = $row['CG_DescriptionEN'];
                                    if ($row['CG_DefaultImage'] !== '') {
                                        $Image01 = 'img/DefaultImageCategory/' . $row['CG_DefaultImage'];
                                    } else {
                                        $Image01 = 'Default/DefaultImage/DefaultImage.png'; 
                                    }
                                    if ($row['CG_IsFile'] == 0) {
                                        $Href01 = 'Ui_ShowPage.php?Send_Category='. $Category3_id.'&Multiplier=1&Search=';
                                    } else if ($row['CG_IsFile'] == 1){
                                        $Href01 = 'Ui_List.php?Send_Category=' . $Category3_id;
                                    }
                                } elseif ($Category3 === 'headingcategories'){
                                    $Name01 = $row['HC_DescriptionTH'];
                                    $Designation01 = $row['HC_DescriptionEN'];
                                    if ($row['HC_DefaultImage'] !== '') {
                                        $Image01 = 'img/DefaultImageHeadingCategory/' . $row['HC_DefaultImage'];
                                    } else {
                                        $Image01 = 'Default/DefaultImage/DefaultImage.png'; 
                                    }
                                    $Href01 = 'Ui_ShowPageMenu.php?Send_MoreMenu='. $Category3_id;
                                } else { 
                                    $Name01 = '';
                                    $Designation01 = '';
                                    $Image01 = '';
                                    $Href01 = '#';
                                }
                                if ($Image01 == '') {
                                    $Image01 = 'Default/DefaultImage/DefaultImage.png';
                                }
                    ?>
                        <a class="small fw-medium" href="<?=$Href01?>">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="<?=$Image01?>" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5><?=$Name01?></h5>
                                <span><?=$Designation01?></span>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                </div>
                <?php } if ($Category4_id != 0) {?>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item2 rounded overflow-hidden">
                    <?php 
                    if ($Category4 === 'category') {
                        $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` = '$Category4_id';";
                    } elseif ($Category4 === 'headingcategories'){
                        $sql = "SELECT * FROM `HeadingCategories` WHERE `HC_Code` = '$Category4_id';";
                    }
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                           $row = $result->fetch_assoc();
                            if ($Category4 === 'category') {
                                $Name02 = $row['CG_DescriptionTH'];
                                $Designation02 = $row['CG_DescriptionEN'];
                                if ($row['CG_DefaultImage'] !== '') {
                                    $Image02 = 'img/DefaultImageCategory/' . $row['CG_DefaultImage'];
                                } else {
                                    $Image02 = 'Default/DefaultImage/DefaultImage.png'; 
                                }
                                if ($row['CG_IsFile'] == 0) {
                                    $Href02 = 'Ui_ShowPage.php?Send_Category='. $Category4_id.'&Multiplier=1&Search=';
                                } else if ($row['CG_IsFile'] == 1){
                                    $Href02 = 'Ui_List.php?Send_Category=' . $Category4_id;
                                }
                            } elseif ($Category4 === 'headingcategories'){
                                $Name02 = $row['HC_DescriptionTH'];
                                $Designation02 = $row['HC_DescriptionEN'];
                                if ($row['HC_DefaultImage'] !== '') {
                                    $Image02 = 'img/DefaultImageHeadingCategory/' . $row['HC_DefaultImage'];
                                } else {
                                    $Image02 = 'Default/DefaultImage/DefaultImage.png'; 
                                }
                                $Href02 = 'Ui_ShowPageMenu.php?Send_MoreMenu='. $Category4_id;
                            } else { 
                                $Name02 = '';
                                $Designation02 = '';
                                $Image02 = '';
                                $Href02 = '#';
                            }
                            if ($Image02 == '') {
                                $Image02 = 'Default/DefaultImage/DefaultImage.png';
                            }
                    ?>
                        <a class="small fw-medium" href="<?=$Href02?>">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="<?=$Image02?>" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5><?=$Name02?></h5>
                                <span><?=$Designation02?></span>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                </div>
            <?php } if ($Category5_id != 0) {?>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item2 rounded overflow-hidden">
                    <?php 
                    if ($Category5 === 'category') {
                        $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` = '$Category5_id';";
                    } elseif ($Category5 === 'headingcategories'){
                        $sql = "SELECT * FROM `HeadingCategories` WHERE `HC_Code` = '$Category5_id';";
                    }
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                           $row = $result->fetch_assoc();
                            if ($Category5 === 'category') {
                                $Name03 = $row['CG_DescriptionTH'];
                                $Designation03 = $row['CG_DescriptionEN'];
                                if ($row['CG_DefaultImage'] !== '') {
                                    $Image03 = 'img/DefaultImageCategory/' . $row['CG_DefaultImage'];
                                } else {
                                    $Image03 = 'Default/DefaultImage/DefaultImage.png'; 
                                }
                                if ($row['CG_IsFile'] == 0) {
                                    $Href03 = 'Ui_ShowPage.php?Send_Category='. $Category5_id.'&Multiplier=1&Search=';
                                } else if ($row['CG_IsFile'] == 1){
                                    $Href03 = 'Ui_List.php?Send_Category=' . $Category5_id;
                                }
                            } elseif ($Category5 === 'headingcategories'){
                                $Name03 = $row['HC_DescriptionTH'];
                                $Designation03 = $row['HC_DescriptionEN'];
                                if ($row['HC_DefaultImage'] !== '') {
                                    $Image03 = 'img/DefaultImageHeadingCategory/' . $row['HC_DefaultImage'];
                                } else {
                                    $Image03 = 'Default/DefaultImage/DefaultImage.png'; 
                                }
                                $Href03 = 'Ui_ShowPageMenu.php?Send_MoreMenu='. $Category5_id;
                            } else { 
                                $Name03 = '';
                                $Designation03 = '';
                                $Image03 = '';
                                $Href03 = '#';
                            }
                            if ($Image03 == '') {
                                $Image03 = 'Default/DefaultImage/DefaultImage.png';
                            }
                    ?>
                        <a class="small fw-medium" href="<?=$Href03?>">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="<?=$Image03?>" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5><?=$Name03?></h5>
                                <span><?=$Designation03?></span>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                </div>
            <?php } if ($Category6_id != 0) {?>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item2 rounded overflow-hidden">
                    <?php 
                    if ($Category6 === 'category') {
                        $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` = '$Category6_id';";
                    } elseif ($Category6 === 'headingcategories'){
                        $sql = "SELECT * FROM `HeadingCategories` WHERE `HC_Code` = '$Category6_id';";
                    }
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                           $row = $result->fetch_assoc();
                            if ($Category6 === 'category') {
                                $Name04 = $row['CG_DescriptionTH'];
                                $Designation04 = $row['CG_DescriptionEN'];
                                if ($row['CG_DefaultImage'] !== '') {
                                    $Image04 = 'img/DefaultImageCategory/' . $row['CG_DefaultImage'];
                                } else {
                                    $Image04 = 'Default/DefaultImage/DefaultImage.png'; 
                                }
                                if ($row['CG_IsFile'] == 0) {
                                    $Href04 = 'Ui_ShowPage.php?Send_Category='. $Category6_id.'&Multiplier=1&Search=';
                                } else if ($row['CG_IsFile'] == 1){
                                    $Href04 = 'Ui_List.php?Send_Category=' . $Category6_id;
                                }
                            } elseif ($Category6 === 'headingcategories'){
                                $Name04 = $row['HC_DescriptionTH'];
                                $Designation04 = $row['HC_DescriptionEN'];
                                if ($row['HC_DefaultImage'] !== '') {
                                    $Image04 = 'img/DefaultImageHeadingCategory/' . $row['HC_DefaultImage'];
                                } else {
                                    $Image04 = 'Default/DefaultImage/DefaultImage.png'; 
                                }
                                $Href04 = 'Ui_ShowPageMenu.php?Send_MoreMenu='. $Category6_id;
                            } else { 
                                $Name04 = '';
                                $Designation04 = '';
                                $Image04 = '';
                                $Href04 = '#';
                            }
                            if ($Image04 == '') {
                                $Image04 = 'Default/DefaultImage/DefaultImage.png';
                            }
                    ?>
                        <a class="small fw-medium" href="<?=$Href04?>">
                            <div class="d-flex">
                                <img class="img-fluid w-100" src="<?=$Image04?>" alt="" style="height:280px;">
                            </div>
                            <div class="p-4 text-center">
                                <h5><?=$Name04?></h5>
                                <span><?=$Designation04?></span>
                            </div>
                        </a>
                    <?php } ?>
                    </div>
                </div>
            <?php } ?>
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

    // เพิ่มการตรวจสอบการคลิกพื้นหลังนอกโมดัล
    // $('.modal').on('click', function(e) {
    //     if ($(e.target).hasClass('modal')) {
    //         $(this).modal('hide');
    //     }
    // });
    $.ajax({
        url: "DB_CountPage.php",
        type: "POST",
        data: { Type: 'setup', Code: 1 },
        dataType: "json",
        success: function(response) {
            console.log("Data Count Page sent successfully:", response);
        },
        error: function() {
            console.log("Error occurred");
        }
    });
});
document.addEventListener("DOMContentLoaded", function() {
    $.ajax({
        url: "DB_PopupShow.php",
        type: "POST",
        data: {
            currentDate: new Date().toISOString()
        },
        dataType: "json",
        success: function(response) {
            var PopupModal = document.getElementById("popupModal");
            var modalContent = '';
            
            for (var i = 0; i < response.length; i++) {
                var modalId = 'modalPopup' + i;
                modalContent +=
                    '<div class="modal fade" id="' + modalId + '" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="' + modalId + 'Label" aria-hidden="true">' +
                    '<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">' +
                    '<div class="modal-content">' +
                    '<div class="modal-body">' +
                    '<img src="' + response[i].image + '" alt="Image" class="img-fluid w-100 h-auto">' +
                    '</div>' +
                    '<div class="modal-header">' +
                    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }
            
            <?php if(!isset($_SESSION['User']) || $_SESSION['User'] === '') : ?>
                PopupModal.innerHTML = modalContent;

                // Triggering the modals
                for (var i = 0; i < response.length; i++) {
                    var modalId = 'modalPopup' + i;
                    var modal = new bootstrap.Modal(document.getElementById(modalId));
                    modal.show();
                }
            <?php else: ?>
            <?php endif; ?>

            console.log("Data Popup sent successfully:", response);
        },
        error: function() {
            console.log("Error occurred");
        }
    });
});
</script>
<?php include("Ma_Footer_Script.php"); ?>