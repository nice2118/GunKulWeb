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
            <h6 class="text-primary"><?= $DescriptionEN ?></h6>
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
                            <section class="content">
                                <div class="row">
                                    <div class="col-12" id="accordion">
                                        <div class="card card-primary card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        1. Lorem ipsum dolor sit amet
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean
                                                    commodo ligula eget dolor.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-primary card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        2. Aenean massa
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
                                                    montes, nascetur ridiculus mus.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-primary card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        3. Donec quam felis
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                                                    Nulla consequat massa quis enim.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-warning card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        4. Donec pede justo
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseFour" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-warning card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseFive">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        5. In enim justo
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseFive" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.
                                                    Nullam dictum felis eu pede mollis pretium.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-warning card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseSix">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        6. Integer tincidunt
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseSix" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.
                                                    Aenean vulputate eleifend tellus.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-danger card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        7. Aenean leo ligula
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseSeven" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-danger card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseEight">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        8. Aliquam lorem ante
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseEight" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                                                    Phasellus viverra nulla ut metus varius laoreet.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-danger card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseNine">
                                                <div class="card-header">
                                                    <h4 class="card-title w-100">
                                                        9. Quisque rutrum
                                                    </h4>
                                                </div>
                                            </a>
                                            <div id="collapseNine" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.
                                                    Curabitur ullamcorper ultricies nisi.
                                                </div>
                                            </div>
                                        </div>
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

<?php include("Ma_Footer_Script.php"); ?>