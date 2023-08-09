<!-- PHP -->
<?php 
    include("DB_Include.php");
    include("DB_Setup.php");
    if (isset($_REQUEST['Send_MoreMenu']) && $_REQUEST['Send_MoreMenu'] !== '') {
        $Send_MoreMenu = $_REQUEST['Send_MoreMenu'];
        $_SESSION['PathPage'] = "Ui_ShowPageMenu.php?Send_MoreMenu=$Send_MoreMenu";
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
                $sql = "SELECT * FROM `HeadingCategories` WHERE `HeadingCategories`.`HC_Code` = $Send_MoreMenu;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $DescriptionTH = $row["HC_DescriptionTH"];
                    $DescriptionEN = $row["HC_DescriptionEN"];
                } else {
                    $DescriptionTH = '';
                    $DescriptionEN = '';
                }
            ?>
            <h3 class="text-primary"><?= $DescriptionEN ?></h3>
            <h2 class="mb-4"><?= $DescriptionTH ?></h2>
        </div>
    </div>
    <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
        <div class="row g-4">
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded overflow-hidden">
                    <div class="container quote px-lg-0">
                        <div class="row g-0 mx-lg-0 py-5">
                            <!-- Main content -->
                            <?php
    // ตั้งค่าตัวแปรเริ่มต้นสำหรับตรวจสอบรอบแรก
    $firstRow = true;
?>

<section class="content">
    <div class="row">
        <div class="col-12" id="accordion">
            <?php
                // ส่งคำสั่ง SQL เพื่อดึงข้อมูล
                $sql = "SELECT * FROM `headinggroup` WHERE `headinggroup`.`HC_Code` = $Send_MoreMenu AND `headinggroup`.`HG_Active` = 1;";
                $result1 = $conn->query($sql);

                // ตรวจสอบข้อมูล
                if ($result1->num_rows > 0) {
                    while ($row1 = $result1->fetch_assoc()) {
                        // อาร์เรย์ที่เก็บค่า class ที่ต้องการให้สุ่ม
                        $classes = array('card-primary', 'card-warning', 'card-danger', 'card-info', 'card-secondary', 'card-success', 'card-fuchsia', 'card-light', 'card-lightblue', 'card-olive', 'card-maroon', 'card-dark', 'card-navy', 'card-lime',  'card-blue', 'card-indigo', 'card-red', 'card-green',  'card-teal', 'card-purple', 'card-orange', 'card-cyan',  'card-gray', 'card-pink', 'card-yellow', 'card-dark');
                                                        
                        // สุ่มค่า index ของอาร์เรย์
                        $randomIndex = array_rand($classes);

                        // ค่า class ที่สุ่มได้
                        $randomClass = $classes[$randomIndex];
            ?>

                    <div class="card <?php echo $randomClass; ?> card-outline">
                        <a class="d-block w-100" data-toggle="collapse" href="#collapse<?php echo $row1["HG_Code"]; ?>">
                            <div class="card-header">
                                <h4>
                                    <?php echo $row1["HG_Text"]; ?>
                                </h4>
                            </div>
                        </a>
                        <?php
                            // ส่งคำสั่ง SQL เพื่อดึงข้อมูล
                            $sql = "SELECT * FROM `Heading` WHERE `Heading`.`HG_Code` = " . $row1["HG_Code"]." AND `Heading`.`HD_Active` = 1";
                            $result2 = $conn->query($sql);

                            // ตรวจสอบข้อมูล
                            if ($result2->num_rows > 0) {
                        ?>
                        <div id="collapse<?php echo $row1["HG_Code"]; ?>" class="collapse <?php echo ($firstRow ? 'show' : ''); ?>" data-parent="#accordion">
                            <div class="card-body">
                            <?php
                                while ($row2 = $result2->fetch_assoc()) {
                            ?>
                                <div class="form-group">
                                    <h5 class="text-primary"><?php echo $row2["HD_Text"]; ?></h5>
                                    <?php
                                        // ส่งคำสั่ง SQL เพื่อดึงข้อมูล
                                        $sql = "SELECT * FROM `Details` WHERE `Details`.`HD_Code` = " . $row2["HD_Code"]." AND `Details`.`DT_Active` = 1";
                                        $result3 = $conn->query($sql);

                                        // ตรวจสอบข้อมูล
                                        if ($result3->num_rows > 0) {
                                            while ($row3 = $result3->fetch_assoc()) {
                                    ?>
                                    <p><?php echo $row3["DT_Text"]; ?></p>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>

                    <?php
                    // ตั้งค่าตัวแปร $firstRow เป็น false หลังจากแสดงเนื้อหาในรอบแรกแล้ว
                    $firstRow = false;
                }
            }
            $conn->close();
            ?>

        </div>
    </div>
</section>

                            <!-- /.content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content -->

<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
<script src="js/bootstrap.bundle.min.js"></script>
<?php include("Ma_Footer_Script.php"); ?>