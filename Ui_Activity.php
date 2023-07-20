<!-- PHP -->
<?php 
include("DB_Include.php");
?>
<?php include("Ma_Head_Link.php"); ?>
<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">Activity</h6>
                <h2 class="mb-4">กิจกรรม</h2>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded overflow-hidden">
                        <div class="container quote px-lg-0">
                            <?PHP
                                $sql = "SELECT * FROM SetupGames;";
                                $result = $conn->query($sql);
                                
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="row g-0 mx-lg-0 py-5">
                                <?= $row['GA_Iframe']; ?>
                            </div>
                            <?PHP
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content -->

<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
<?php include("Ma_Footer_Script.php"); ?>