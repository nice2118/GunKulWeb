<!-- PHP -->
<?php 
    include("DB_Include.php");
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
<?php include("Head_Link.php"); ?>
<?php include("Head.php"); ?>
<?php include("Carousel.php"); ?>

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
                <h6 class="text-primary"><?= $row["CG_DescriptionEN"] ?></h6>
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
            </div>
        </div>
    </div>
    <!-- Content -->

<?php include("Footer.php"); ?>
<?php include("FirstFooter_Script.php"); ?>
<?php include("Footer_Script.php"); ?>