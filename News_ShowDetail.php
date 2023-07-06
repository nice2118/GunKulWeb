<!-- PHP -->
<?php 
    include("DB_Include.php");
    if (isset($_GET['Send_IDNews']) && $_GET['Send_IDNews'] !== '') {
        $t_id = $_GET['Send_IDNews'];
      } else {
        $_SESSION['StatusTitle'] = "Error!";
        $_SESSION['StatusMessage'] = 'ไม่พบเลขที่เอกสารนี้';
        $_SESSION['StatusAlert'] = "error";
        header("Location: ".$_SESSION['PathPage']);
        unset($_SESSION['PathPage']);
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
                <h6 class="text-primary">Form News & Activities</h6>
                <h1 class="mb-4">สร้างข่าวสารและกิจกรรม</h1>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <?php
                        $sql = "SELECT * FROM `news` WHERE `news`.`NA_Code` = $t_id;";
                        
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $decodedText = base64_decode($row["NA_Note"]);
                            if ($decodedText !== false) {
                                echo $decodedText;
                            } else {
                                echo $row["NA_Note"];
                            }
                        }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Content -->

<?php include("Footer.php"); ?>
<?php include("FirstFooter_Script.php"); ?>
<?php include("Footer_Script.php"); ?>