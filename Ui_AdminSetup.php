<?php 
include("DB_Include.php"); 
include("Fn_RecursiveCategory.php"); 
$_SESSION['PathPage'] = "Ui_AdminSetup.php";
$US_Prefix = "";
?>
<?php include("Ma_Head_Link.php"); ?>
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
  #image, #imageCategory, #imageMenuCategory, #imageUser, #imagePopup {
    display: none;
  }
</style>
<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>
<?PHP
    $sql = "SELECT * FROM Setup";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $CodeSetup = $row["SU_Code"];
        $DefaultImageNews = $row["SU_DefaultImageNews"];
        $PathFolderNews = $row["SU_PathDefaultImageNews"];
        $PathFolderGallery = $row["SU_PathDefaultImageGallery"];
        $PathDefaultFile = $row["SU_PathDefaultFile"];
        $HeaderDescriptionTH = $row["SU_HeaderDescriptionTH"];
        $HeaderDescriptionEN = $row["SU_HeaderDescriptionEN"];
    } else {
        unset($sql);
        $sql = "INSERT INTO `Setup` (`CG_Entity No.`,`CG_CreateDate`) VALUES (1, CURRENT_TIMESTAMP)";
        if ($conn->query($sql) === true) {
            $CodeSetup = 1;
            $DefaultImageNews = "";
            $PathFolderNews = "";
            $PathFolderGallery = "";
            $PathDefaultFile = "";
            $HeaderDescriptionTH = "";
            $HeaderDescriptionEN = "";
        }
    }
    unset($sql);
    $sql = "SELECT * FROM IndexSetup";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ISCode = $row["IS_Code"];
        $ISGroupCategory1 = $row["IS_GroupCategory1"];
        $ISGroupCategory2 = $row["IS_GroupCategory2"];
        $ISGroupMenu1 = $row["IS_GroupMenu1"];
        $ISGroupMenu1_Box1 = $row["IS_GroupMenu1_Box1"];
        $ISGroupMenu2 = $row["IS_GroupMenu2"];
        $ISGroupMenu2_Box2 = $row["IS_GroupMenu2_Box2"];
        $ISGroupMenu3 = $row["IS_GroupMenu3"];
        $ISGroupMenu3_Box3 = $row["IS_GroupMenu3_Box3"];
        $ISGroupMenu4 = $row["IS_GroupMenu4"];
        $ISGroupMenu4_Box4 = $row["IS_GroupMenu4_Box4"];
    } else {
        unset($sql);
        $sql = "INSERT INTO `IndexSetup` (`IS_Code`,`IS_CreateDate`) VALUES (1, CURRENT_TIMESTAMP)";
        if ($conn->query($sql) === true) {
            $ISCode = 1;
            $ISGroupCategory1 = "";
            $ISGroupCategory2 = "";
            $ISGroupMenu1 = "";
            $ISGroupMenu1_Box1 = "";
            $ISGroupMenu2 = "";
            $ISGroupMenu2_Box2 = "";
            $ISGroupMenu3 = "";
            $ISGroupMenu3_Box3 = "";
            $ISGroupMenu4 = "";
            $ISGroupMenu4_Box4 = "";
        }
    }
    unset($sql);
?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h3 class="text-primary">Setup & Set system defaults</h3>
                <h2 class="mb-4">ตั้งค่าและเซ็ตค่าเริ่มต้นระบบ</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-12 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <section class="content">
                    <!-- <form action="Pro_EditSetup.php" method="post" enctype="multipart/form-data">
                        <div class="row my-3">
                            <div class="col-12 text-center text-md-end">
                                <button type="submit" class="btn btn-success rounded-pill py-2 px-5 add-image-btn text-end"><i class="fa fa-save"></i></button>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Activities</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="Pro_EditSetup.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="inputName">รูปเริ่มต้นของข่าวและกิจกรรม</label>
                                                <div class="container-fluid bg-light overflow-hidden px-lg-0">
                                                    <div class="container quote px-lg-0">
                                                        <div class="row g-0 mx-lg-0">
                                                            <div class="col-lg-4 quote-text py-0 wow fadeIn" data-wow-delay="0.5s"></div>
                                                            <div class="col-lg-4 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="max-height: 200px; max-width: 200px; min-height: 100px; min-width: 100px;">
                                                                <div class="position-relative">
                                                                    <input type="file" class="form-control border-1" name="image" id="image" accept="image/*">
                                                                    <input type="hidden" name="ID" value="<?= $CodeSetup ?>" class="form-control">
                                                                    <input type="hidden" name="DefaultNameImageNews" value="0" class="form-control">
                                                                    <input type="hidden" name="OldNameImageNews" value="<?= $DefaultImageNews ?>" class="form-control">
                                                                    <label for="image" style="cursor: pointer;">
                                                                        <?php
                                                                            if (isset($DefaultImageNews) && $DefaultImageNews !== '') {
                                                                                $PathDefaultImage = $PathFolderNews . $DefaultImageNews;
                                                                            } else {
                                                                                $folderPath = 'Default/DefaultImage/';
                                                                                $files = scandir($folderPath);
                                                                                $imageFiles = array_diff($files, array('.', '..'));
                                                                                $latestImage = '';
                                                                                $latestTimestamp = 0;
                                                                                foreach ($imageFiles as $imageFile) {
                                                                                    $filePath = $folderPath . $imageFile;
                                                                                    $timestamp = filemtime($filePath);

                                                                                    if ($timestamp > $latestTimestamp) {
                                                                                        $latestTimestamp = $timestamp;
                                                                                        $latestImage = $imageFile;
                                                                                    }
                                                                                }
                                                                                if (!empty($latestImage)) {
                                                                                    $PathDefaultImage = $folderPath . $latestImage;
                                                                                } else {
                                                                                    echo "ไม่พบภาพในโฟลเดอร์";
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <img id="previewImage" class="img-fluid rounded" src="<?= $PathDefaultImage ?>" alt="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 quote-text py-0 wow fadeIn" data-wow-delay="0.5s"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">ที่เก็บที่อยู่รูปข่าว</label>
                                                <input type="text" name="PathFolderNews" value="<?= $PathFolderNews; ?>" class="form-control">
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">ที่เก็บแกลลอรี่</label>
                                                <input type="text" name="PathFolderGallery" value="<?= $PathFolderGallery; ?>" class="form-control">
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">ที่เก็บไฟล์</label>
                                                <input type="text" name="PathDefaultFile" value="<?= $PathDefaultFile; ?>" class="form-control">
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">รายละเอียดไทย</label>
                                                <input type="text" name="HeaderDescriptionTH" value="<?= $HeaderDescriptionTH; ?>" class="form-control">
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">รายละเอียดอังกฤษ</label>
                                                <input type="text" name="HeaderDescriptionEN" value="<?= $HeaderDescriptionEN; ?>" class="form-control">
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-12 text-center text-md-end">
                                                    <button type="submit" class="btn btn-success rounded-pill py-2 px-5 add-image-btn text-end"><i class="fa fa-save"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Category</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <ul class="todo-list" data-widget="todo-list">
                                            <?php
                                                function renderRow($row,$multiplier) {
                                                    global $conn;
                                            ?>
                                                    <span class="text"><?=$row["CG_Name"]?></span>
                                                    <div class="tools">
                                                        <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertCategory(<?php echo $row["CG_Entity No."];?>, '<?php echo $row["CG_Name"];?>')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#Category" data-entityno="<?= $row["CG_Entity No."] ?>" data-isfile="<?= $row["CG_IsFile"] ?>" data-entityrelationno="<?= $row["CG_Entity Relation No."] ?>" data-name="<?= $row["CG_Name"]; ?>" data-descriptionth="<?= $row["CG_DescriptionTH"] ?>" data-descriptionen="<?= $row["CG_DescriptionEN"] ?>" data-ecimage="<?= $row["CG_DefaultImage"]; ?>"><i class="fas fa-edit"></i> </button>
                                                    </div>
                                                <?php
                                                    $sql = "SELECT *
                                                            FROM category WHERE `CG_Entity Relation No.` = '{$row["CG_Entity No."]}' 
                                                            ORDER BY `CG_Entity No.`, `CG_Entity Relation No.`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        $multiplier++;
                                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <li class="my-2">
                                                <?php
                                                    for ($i = 1; $i <= $multiplier; $i++) {
                                                        echo '<span class="text"></span><span class="text"></span><span class="text"></span>';
                                                    }
                                                    renderRow($row, $multiplier);
                                                ?>
                                                </li>
                                                <?PHP
                                                        }
                                                    }
                                                    unset($sql);
                                                }
                                                    $sql = "SELECT *
                                                        FROM `category` WHERE `CG_Entity Relation No.` = 0
                                                        ORDER BY `CG_Entity No.`, `CG_Entity Relation No.`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                        echo '<li class="my-2">';
                                                        renderRow($row,0);
                                                        echo '</li>';
                                                        }
                                                    }
                                                    unset($sql);
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#Category" data-entityno="0" data-isfile="0" data-entityrelationno="0" data-name="" data-descriptionth="" data-descriptionen="" data-ecimage=""><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-teal collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Entry Popup</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="todo-list" data-widget="todo-list">
                                                <?PHP
                                                        $sql = "SELECT * FROM `alertpopup` ORDER BY `AP_Code`;";
                                                        $result = $conn->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <li class="my-2">
                                                        <span class="text"><?=$row["AP_Name"]?></span>
                                                        <div class="tools">
                                                        <?php
                                                            if ($row["AP_Active"] == 1) {
                                                                echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButtonPopup" id="toggleButtonPopup1" data-sendHiddenPopupID="' . $row['AP_Code'] . '"><i class="fa fa-eye"></i></a>';
                                                            } else {
                                                                echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButtonPopup" id="toggleButtonPopup0" data-sendHiddenPopupID="' . $row['AP_Code'] . '"><i class="fa fa-eye-slash"></i></a>';
                                                            }
                                                        ?>
                                                            <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertPopup(<?php echo $row["AP_Code"];?>, '<?php echo $row["AP_Image"];?>')"><i class="fas fa-trash"></i></a>  	 
                                                            <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#modalpopup" data-apcode="<?= $row["AP_Code"] ?>" data-apname="<?= $row["AP_Name"] ?>" data-apimage="<?= $row["AP_Image"] ?>" data-apdatestart="<?= $row["AP_DateStart"] ?>" data-apdateend="<?= $row["AP_DateEnd"] ?>"><i class="fas fa-edit"></i></button>
                                                        </div>
                                                    </li>
                                                <?PHP
                                                        }
                                                    }
                                                    unset($sql);
                                                ?>
                                            </ui>
                                            <div class="form-group text-center text-md-end">
                                                <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#modalpopup" data-apcode="" data-apname="" data-apimage="" data-apdatestart="" data-apdateend=""><i class="fa fa-plus"></i></button>
                                            </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->                         
                            </div>

                            <div class="col-md-6">
                                <div class="card card-danger collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Games and recreational activities</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="Pro_EditSetup.php" method="post" enctype="multipart/form-data">
                                            <div id="form-container">
                                            <?PHP
                                                $sql = "SELECT * FROM SetupGames;";
                                                $result = $conn->query($sql);
                                                
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <div class="form-group">
                                                    <textarea name="Games[]" class="form-control border-1 my-2" placeholder="iframe" style="height: 110px;"><?php echo htmlspecialchars($row['GA_Iframe'], ENT_QUOTES); ?></textarea>
                                                </div>
                                            <?PHP
                                                    }
                                                }
                                            ?>
                                            </div>
                                            <div class="form-group text-center text-md-end">
                                                <button type="button" class="btn btn-danger rounded-pill py-2 px-3 add-image-btn text-end" id="deleteButton"><i class="fas fa-trash"></i></button>
                                                <button type="button" class="btn btn-primary rounded-pill py-2 px-3 add-image-btn text-end" id="addButton"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="row my-3">
                                                <div class="col-12 text-center text-md-end">
                                                    <button type="submit" class="btn btn-success rounded-pill py-2 px-5 add-image-btn text-end"><i class="fa fa-save"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Menu Categories</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="todo-list" data-widget="todo-list">
                                            <?PHP
                                                    $sql = "SELECT * FROM `headingcategories` ORDER BY `HC_Code`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <li class="my-2">
                                                    <span class="text"><?=$row["HC_Text"]?></span>
                                                    <div class="tools">
                                                        <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertMenuCategory(<?php echo $row["HC_Code"];?>, '<?php echo $row["HC_Text"];?>', 'headingcategories')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#MenuCategory" data-hcCode="<?= $row["HC_Code"] ?>" data-hcText="<?= $row["HC_Text"] ?>" data-hcdescriptionth="<?= $row["HC_DescriptionTH"] ?>" data-hcdescriptionen="<?= $row["HC_DescriptionEN"] ?>" data-hcimage="<?= $row["HC_DefaultImage"] ?>"><i class="fas fa-edit"></i> </button>
                                                        <button type="button" class="btn btn-link py-0 px-1 text-end text-primary" data-bs-toggle="modal" data-bs-target="#MasterMenuCategory" data-hccode="<?= $row["HC_Code"] ?>"><i class="fas fa-graduation-cap"></i></button>
                                                    </div>
                                                </li>
                                            <?PHP
                                                    }
                                                }
                                                unset($sql);
                                            ?>
                                        </ui>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#MenuCategory" data-hcCode="0" data-hcText="" data-hcdescriptionth="" data-hcdescriptionen="" data-hcimage=""><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">General</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="todo-list" data-widget="todo-list">
                                            <?PHP
                                                    $sql = "SELECT * FROM `engravedcategory` ORDER BY `EC_Code`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <li class="my-2">
                                                    <span class="text"><?=$row["EC_Name"]?></span>
                                                    <div class="tools">
                                                        <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertEngravedCategory(<?php echo $row["EC_Code"];?>, '<?php echo $row["EC_Name"];?>')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#engravedcategory" data-eccode="<?= $row["EC_Code"] ?>" data-ecname="<?= $row["EC_Name"] ?>" data-ecdescriptionth="<?= $row["EC_DescriptionTH"] ?>" data-ecdescriptionen="<?= $row["EC_DescriptionEN"] ?>"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-link py-0 px-1 text-end text-primary" data-bs-toggle="modal" data-bs-target="#EngravedActivities" data-eccode="<?= $row["EC_Code"] ?>"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </li>
                                            <?PHP
                                                    }
                                                }
                                                unset($sql);
                                            ?>
                                        </ui>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#engravedcategory" data-eccode="0" data-hcname="" data-ecdescriptionth="" data-ecdescriptionen=""><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-navy collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">User Setup</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="todo-list" data-widget="todo-list">
                                                <?PHP
                                                        $sql = "SELECT * FROM `User` ORDER BY `US_Username`;";
                                                        $result = $conn->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <li class="my-2">
                                                        <span class="text"><?=$row["US_Username"]?> / <?=$row["US_Fname"]?></span>
                                                        <div class="tools">
                                                        <?php
                                                            if ($row["US_Active"] == 1) {
                                                                echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton1" data-sendHiddenID="' . $row['US_Username'] . '"><i class="fa fa-eye"></i></a>';
                                                            } else {
                                                                echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton0" data-sendHiddenID="' . $row['US_Username'] . '"><i class="fa fa-eye-slash"></i></a>';
                                                            }
                                                        ?>
                                                            <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertUser(<?php echo $row["US_Username"];?>)"><i class="fas fa-trash"></i></a>
                                                            <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#modaluser" data-ustype="edit" data-ususername="<?= $row["US_Username"] ?>" data-uspassword="<?= $row["US_Password"] ?>" data-usprefix="<?= $row["US_Prefix"] ?>" data-ptcode="<?= $row["PT_Code"] ?>" data-usfname="<?= $row["US_Fname"] ?>" data-uslname="<?= $row["US_Lname"] ?>" data-usimage="<?= $row["US_Image"] ?>"><i class="fas fa-edit"></i></button>
                                                        </div>
                                                    </li>
                                                <?PHP
                                                        }
                                                    }
                                                    unset($sql);
                                                ?>
                                            </ui>
                                            <div class="form-group text-center text-md-end">
                                                <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#modaluser" data-ustype="add" data-ususername="" data-uspassword="" data-usprefix="" data-ptcode="" data-usfname="" data-uslname="" data-usimage=""><i class="fa fa-plus"></i></button>
                                            </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                 <!-- /.card -->
                                <div class="card card-olive collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Position Setup</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="todo-list" data-widget="todo-list">
                                            <?PHP
                                                $sql = "SELECT * FROM `Position` ORDER BY `PT_Code`;";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <li class="my-2">
                                                    <span class="text"><?=$row["PT_Name"]?></span>
                                                    <div class="tools">
                                                        <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertPosition(<?php echo $row["PT_Code"];?>, '<?php echo $row["PT_Name"];?>')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#modalposition" data-ptcode="<?= $row["PT_Code"] ?>" data-ptname="<?= $row["PT_Name"] ?>"><i class="fas fa-edit"></i></button>
                                                    </div>
                                                </li>
                                            <?PHP
                                                    }
                                                }
                                                unset($sql);
                                            ?>
                                        </ui>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#modalposition" data-ptcode="0" data-ptname=""><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                 <!-- /.card -->
                                <div class="card card-maroon collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Index Setup</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="Pro_EditIndexSetup.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="PathFolderNews">กลุ่มที่ 1</label>
                                                <select class="form-select border-1" id="IS_GroupCategory1" name="IS_GroupCategory1">
                                                    <option></option>
                                                    <?php
                                                        $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
                                                        $result = $conn->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                $selected = ($row["CG_Entity No."] == $ISGroupCategory1) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?= $row["CG_Entity No."] ?>" <?= $selected ?>><?= $row["CG_Name"] ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">กลุ่มที่ 2</label>
                                                <select class="form-select border-1" id="IS_GroupCategory2" name="IS_GroupCategory2">
                                                    <option></option>
                                                    <?php
                                                        $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
                                                        $result = $conn->query($sql);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                $selected = ($row["CG_Entity No."] == $ISGroupCategory2) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?= $row["CG_Entity No."] ?>" <?= $selected ?>><?= $row["CG_Name"] ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">หมวดที่ 1</label>
                                                <select class="form-select border-1" id="IS_GroupMenu1" name="IS_GroupMenu1">
                                                    <option></option>
                                                    <option value="category" <?= ("category" == $ISGroupMenu1) ? 'selected' : '' ?>>Category</option>
                                                    <option value="headingcategories" <?= ("headingcategories" == $ISGroupMenu1) ? 'selected' : '' ?>>Menu Categories</option>
                                                </select>
                                            </div>
                                            <div id="IS_Box1"></div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">หมวดที่ 2</label>
                                                <select class="form-select border-1" id="IS_GroupMenu2" name="IS_GroupMenu2">
                                                    <option></option>
                                                    <option value="category" <?= ("category" == $ISGroupMenu2) ? 'selected' : '' ?>>Category</option>
                                                    <option value="headingcategories" <?= ("headingcategories" == $ISGroupMenu2) ? 'selected' : '' ?>>Menu Categories</option>
                                                </select>
                                            </div>
                                            <div id="IS_Box2"></div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">หมวดที่ 3</label>
                                                <select class="form-select border-1" id="IS_GroupMenu3" name="IS_GroupMenu3">
                                                    <option></option>
                                                    <option value="category" <?= ("category" == $ISGroupMenu3) ? 'selected' : '' ?>>Category</option>
                                                    <option value="headingcategories" <?= ("headingcategories" == $ISGroupMenu3) ? 'selected' : '' ?>>Menu Categories</option>
                                                </select>
                                            </div>
                                            <div id="IS_Box3"></div>
                                            <div class="form-group my-3">
                                                <label for="PathFolderNews">หมวดที่ 4</label>
                                                <select class="form-select border-1" id="IS_GroupMenu4" name="IS_GroupMenu4">
                                                    <option></option>
                                                    <option value="category" <?= ("category" == $ISGroupMenu4) ? 'selected' : '' ?>>Category</option>
                                                    <option value="headingcategories" <?= ("headingcategories" == $ISGroupMenu4) ? 'selected' : '' ?>>Menu Categories</option>
                                                </select>
                                            </div>
                                            <div id="IS_Box4"></div>
                                            <div class="row my-3">
                                                <div class="col-12 text-center text-md-end">
                                                    <button type="submit" class="btn btn-success rounded-pill py-2 px-5 add-image-btn text-end"><i class="fa fa-save"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <div class="card card-purple">
                                    <div class="card-header">
                                        <h3 class="card-title text-white">Menu</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="todo-list" data-widget="todo-list">
                                            <?PHP
                                                    $sql = "SELECT * FROM `Menu`;";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <li class="my-2">
                                                    <span class="text"><?=$row["MN_Name"]?></span>
                                                    <div class="tools">
                                                        <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertMenu(<?php echo $row["MN_Code"];?>, '<?php echo $row["MN_Name"];?>')"><i class="fas fa-trash"></i></a>
                                                        <button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#modalmenu" data-mncode="<?= $row["MN_Code"] ?>" data-mnname="<?= $row["MN_Name"] ?>"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-link py-0 px-1 text-end text-primary" data-bs-toggle="modal" data-bs-target="#modalmenusub" data-mncodesub="<?= $row["MN_Code"] ?>" data-pmtype="menu"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </li>
                                            <?PHP
                                                    }
                                                }
                                                unset($sql);
                                            ?>
                                        </ui>
                                        <div class="form-group text-center text-md-end">
                                            <button type="button" class="btn btn-primary rounded-pill py-1 px-4 add-image-btn text-end" data-bs-toggle="modal" data-bs-target="#modalmenu" data-mncode="0" data-mnname=""><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-12 text-center text-md-end">
                                <button type="submit" class="btn btn-success rounded-pill py-2 px-5 add-image-btn text-end"><i class="fa fa-save"></i></button>
                            </div>
                        </div> -->
                    <!-- </form> -->
                </section>
            </div>
        </div>
    </div>
    <!-- Content -->

    <!-- Modal Category-->
    <div class="modal fade" id="Category" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CategoryLabel">Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormCategory" action="Pro_Add&EditCategory.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <!-- <div class="col-3 col-sm-2"> -->
                                <!-- <h6 class="text-primary">รหัส</h6> -->
                                <input type="hidden" id="CG_EntityNo" name="CG_EntityNo" class="form-control border-1" placeholder="0" readonly>
                                <input type="hidden" id="CG_OldImage" name="CG_OldImage" class="form-control border-1" placeholder="0" readonly>
                            <!-- </div> -->
                            <div class="col-5 col-sm-5">
                                <h6 class="text-primary">ลำดับชั้นที่จะต่อ</h6>
                                <select class="form-select border-1" id="CG_EntityRelationNo" name="CG_EntityRelationNo">
                                        <option></option>
                                    <?php
                                        // $SelectFilterCategoryEntityNo = SearchCategorySub(0);
                                        // echo $SelectFilterCategoryEntityNo;
                                        // $sql = "SELECT * FROM `category` WHERE (`CG_Entity No.` IN ($SelectFilterCategoryEntityNo));";
                                        $sql = "SELECT * FROM `category`;";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = ($row["CG_Entity No."] == $CG_EntityRelationNo) ? 'selected' : ''; // เปรียบเทียบกับ $CG_EntityRelationNo ที่ได้มาจากคำสั่งด้านบน
                                    ?>
                                        <option value="<?= $row["CG_Entity No."] ?>" <?= $selected ?>><?= $row["CG_Name"] ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <!-- <input type="Text" id="CG_EntityRelationNo" name="CG_EntityRelationNo" class="form-control border-1" value="" placeholder=""> -->
                                <!-- <input type="number" id="CG_EntityRelationNo" name="CG_EntityRelationNo" class="form-control border-1" value="" placeholder="0" min="0" oninput="this.value = this.value < 0 ? 0 : this.value"> -->
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="CG_Name" name="CG_Name" class="form-control border-1" placeholder="ชื่อหัวข้อ" required>
                            </div>
                            <div class="col-1 col-sm-1">
                                <div class="form-group text-center">
                                    <h6 class="text-primary my-05">ไฟล์</h6>
                                    <input class="form-check-input py-3 px-3" type="checkbox" id="CG_IsFile" name="CG_IsFile">
                                </div>
                                
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาไทย</h6>
                                <input type="Text" id="CG_DescriptionTH" name="CG_DescriptionTH" class="form-control border-1" placeholder="ชื่อภาษาไทย" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาอังกฤษ</h6>
                                <input type="Text" id="CG_DescriptionEN" name="CG_DescriptionEN" class="form-control border-1" placeholder="ชื่อภาษาอังกฤษ" required>
                            </div>
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ภาพเริ่มต้น</h6>
                                <input type="file" class="form-control border-1" name="imageCategory" id="imageCategory" accept="image/*">
                                <label for="imageCategory" style="cursor: pointer;">
                                    <div id="modalPreviewImageCategory"></div>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal MenuCategory-->
    <div class="modal fade" id="MenuCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="MenuCategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="MenuCategoryLabel">Menu Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormMenuCategory" action="Pro_Add&EditMenuCategory.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <!-- <div class="col-3 col-sm-2"> -->
                                <!-- <h6 class="text-primary">รหัส</h6> -->
                                <input type="hidden" name="Send_MenuCategoryType" value="headingcategories">
                                <input type="hidden" id="Send_OldImage" name="Send_OldImage" value="headingcategories">
                                <input type="hidden" id="Send_Relation" name="Send_Relation" value="0">
                                <input type="hidden" id="Send_Code" name="Send_Code" class="form-control border-1" placeholder="0" readonly>
                            <!-- </div> -->
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="Send_Text" name="Send_Text" class="form-control border-1" placeholder="ชื่อหัวข้อ" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาไทย</h6>
                                <input type="Text" id="Send_descriptionth" name="Send_descriptionth" class="form-control border-1" placeholder="ชื่อภาษาไทย" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาอังกฤษ</h6>
                                <input type="Text" id="Send_descriptionen" name="Send_descriptionen" class="form-control border-1" placeholder="ชื่อภาษาอังกฤษ" required>
                            </div>
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ภาพเริ่มต้น</h6>
                                <input type="file" class="form-control border-1" name="imageMenuCategory" id="imageMenuCategory" accept="image/*">
                                <label for="imageMenuCategory" style="cursor: pointer;">
                                    <div id="modalPreviewImageMenuCategory"></div>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal MasterMenuCategory-->
    <div class="modal fade" id="MasterMenuCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="MasterMenuCategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="MasterMenuCategoryLabel">General Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormMasterMenuCategory" action="Pro_Add&EditMasterMenuCategory.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div id="modalContentMasterMenuCategory"></div>
                            <div class="form-group text-center text-md-end my-2">
                                <button type="button" class="btn btn-primary rounded-pill py-2 px-3 add-image-btn text-end" id="addButtonMasterMenuCategory"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal EngravedCategory-->
    <div class="modal fade" id="engravedcategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="engravedcategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="engravedcategoryLabel">Engraved Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormEngravedCategory" action="Pro_Add&EditEngravedCategory.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <!-- <div class="col-3 col-sm-2"> -->
                                <!-- <h6 class="text-primary">รหัส</h6> -->
                                <input type="hidden" id="EC_code" name="EC_code" class="form-control border-1" placeholder="0" readonly>
                            <!-- </div> -->
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="EC_name" name="EC_name" class="form-control border-1" placeholder="ชื่อหัวข้อ" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาไทย</h6>
                                <input type="Text" id="EC_descriptionth" name="EC_descriptionth" class="form-control border-1" placeholder="ชื่อภาษาไทย" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">ชื่อภาษาอังกฤษ</h6>
                                <input type="Text" id="EC_descriptionen" name="EC_descriptionen" class="form-control border-1" placeholder="ชื่อภาษาอังกฤษ" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal EngravedActivities-->
    <div class="modal fade" id="EngravedActivities" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EngravedActivitiesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EngravedActivitiesLabel">General Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormEngravedActivities" action="Pro_Add&EditEngravedActivities.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div id="modalContent"></div>
                            <div class="form-group text-center text-md-end my-2">
                                <button type="button" class="btn btn-primary rounded-pill py-2 px-3 add-image-btn text-end" id="addButtonGeneralSettings"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal User-->
    <div class="modal fade" id="modaluser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modaluserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaluserLabel">General User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormmodaluser" action="Pro_Add&EditUser.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <input type="hidden" id="US_Type" name="US_Type" class="form-control border-1" placeholder="Code" required>
                            <input type="hidden" id="US_Image" name="US_Image" class="form-control border-1" placeholder="0" readonly>
                            <div class="col-2 col-sm-2">
                                <h6 class="text-primary">คำนำหน้า</h6>
                                <select class="form-select border-1" id="US_Prefix" name="US_Prefix" required>
                                    <option value="">เลือกคำนำหน้า</option>
                                    <option value="นาย" <?php if ('นาย' == $US_Prefix) echo 'selected'; ?>>นาย</option>
                                    <option value="นาง" <?php if ('นาง' == $US_Prefix) echo 'selected'; ?>>นาง</option>
                                    <option value="นางสาว" <?php if ('นางสาว' == $US_Prefix) echo 'selected'; ?>>นางสาว</option>
                                </select>
                            </div>
                            <div class="col-5 col-sm-5">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="US_Fname" name="US_Fname" class="form-control border-1" placeholder="ชื่อ" required>
                            </div>
                            <div class="col-5 col-sm-5">
                                <h6 class="text-primary">นามสกุล</h6>
                                <input type="Text" id="US_Lname" name="US_Lname" class="form-control border-1" placeholder="นามสกุล">
                            </div>
                            <div class="col-4 col-sm-4">
                                <h6 class="text-primary">ตำแหน่ง</h6>
                                <select class="form-select border-1" id="PT_Code" name="PT_Code" required>
                                    <option value="">เลือกตำแหน่ง</option>
                                    <?php
                                        $sql = "SELECT * FROM `position`;";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = ($row["PT_Code"] == $PT_Code) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $row["PT_Code"] ?>" <?= $selected ?>><?= $row["PT_Name"] ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4 col-sm-4">
                                <h6 class="text-primary">Username</h6>
                                <input type="Text" id="US_Username" name="US_Username" class="form-control border-1" placeholder="Username" required>
                            </div>
                            <div class="col-4 col-sm-4">
                                <h6 class="text-primary">Password</h6>
                                <input type="Password" id="US_Password" name="US_Password" class="form-control border-1" placeholder="Password" required>
                            </div>
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ภาพเริ่มต้น</h6>
                                <input type="file" class="form-control border-1" name="imageUser" id="imageUser" accept="image/*">
                                <label for="imageUser" style="cursor: pointer;">
                                    <div id="modalPreviewImageUser"></div>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Position-->
    <div class="modal fade" id="modalposition" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalpositionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalpositionLabel">General Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormmodalposition" action="Pro_Add&EditPosition.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <input type="hidden" id="PT_code" name="PT_code" class="form-control border-1" placeholder="Code" required>
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="PT_name" name="PT_name" class="form-control border-1" placeholder="ชื่อ" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Menu-->
    <div class="modal fade" id="modalmenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalmenuLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalmenuabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Pro_Add&EditMenu.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <!-- <div class="col-3 col-sm-2"> -->
                                <!-- <h6 class="text-primary">รหัส</h6> -->
                                <input type="hidden" id="MN_Code" name="MN_Code" value="">
                            <!-- </div> -->
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="MN_Name" name="MN_Name" class="form-control border-1" placeholder="ชื่อหัวข้อ" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Menu Sub-->
    <div class="modal fade" id="modalmenusub" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalmenusubLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalmenusubabel">Menu Sub</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormMenu" action="Pro_Add&EditPermissionMenu.php" method="post" enctype="multipart/form-data">
                        <div id="modalContentMenuDB"></div>    
                        <div id="modalContentMenu"></div>
                        <div class="form-group text-center text-md-end my-2">
                                <button type="button" class="btn btn-primary rounded-pill py-2 px-3 add-image-btn text-end" id="addButtonMenu"><i class="fa fa-plus"></i></button>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Menu Sub2-->
    <div class="modal fade" id="modalmenusub2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalmenusub2Label" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalmenusub2abel">Menu Sub2</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormMenu2" action="Pro_Add&EditPermissionMenu.php" method="post" enctype="multipart/form-data">
                        <div id="modalContentMenu2DB"></div>    
                        <div id="modalContentMenu2"></div>
                        <div class="form-group text-center text-md-end my-2">
                                <button type="button" class="btn btn-primary rounded-pill py-2 px-3 add-image-btn text-end" id="addButtonMenuSub2"><i class="fa fa-plus"></i></button>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Popup-->
    <div class="modal fade" id="modalpopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalupopupLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalpopupLabel">General Popup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalFormmodalpopup" action="Pro_Add&Editpopup.php" method="post" enctype="multipart/form-data">
                        <div class="row g-2 my-2">
                            <input type="hidden" id="AP_Code" name="AP_Code" class="form-control border-1" placeholder="Code" required>
                            <input type="hidden" id="AP_OldImage" name="AP_OldImage" class="form-control border-1" placeholder="0" readonly>
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ชื่อ</h6>
                                <input type="Text" id="AP_Name" name="AP_Name" class="form-control border-1" placeholder="ชื่อ" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">วันที่เริ่มแสดง</h6>
                                <input type="Date" id="AP_DateStart" name="AP_DateStart" class="form-control border-1" placeholder="วันที่เริ่มแสดง" required>
                            </div>
                            <div class="col-6 col-sm-6">
                                <h6 class="text-primary">วันที่สิ้นสุดแสดง</h6>
                                <input type="Date" id="AP_DateEnd" name="AP_DateEnd" class="form-control border-1" placeholder="วันที่สิ้นสุดแสดง" required>
                            </div>
                            <div class="col-12 col-sm-12">
                                <h6 class="text-primary">ภาพที่ให้แสดง</h6>
                                <input type="file" class="form-control border-1" name="imagePopup" id="imagePopup" accept="image/*">
                                <label for="imagePopup" style="cursor: pointer;">
                                    <div id="modalPreviewImagePopup"></div>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include("Ma_Footer.php"); ?>
<!-- เมื่อโหลดหน้าใหม่ให้เลื่อนลงมากลางจอ -->
<script>
    function redirectToPage() {
        // หากต้องการเลื่อนลงมากลางหน้าต่างใหม่ที่เปิด คุณสามารถใช้ตำแหน่ง scrollTop
        // ของหน้าต่างใหม่เท่ากับครึ่งหนึ่งของความสูงของหน้าต่าง
        const windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        const halfWindowHeight = windowHeight / 2;
        window.scrollTo(0, halfWindowHeight);
    }
    setTimeout(redirectToPage, 0);
</script>
<!-- Show Image -->
<script>
    document.getElementById('image').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImage = document.getElementById('previewImage');
            previewImage.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            var defaultImagePath = document.getElementById('DefaultNameImageNews').value;
            previewImage.src = defaultImagePath;
        }
    });

    document.getElementById('imageCategory').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImageCategory = document.getElementById('previewImageCategory');
            previewImageCategory.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('imageMenuCategory').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImageMenuCategory = document.getElementById('previewImageMenuCategory');
            previewImageMenuCategory.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('imageUser').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImageUser = document.getElementById('previewImageUser');
            previewImageUser.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('imagePopup').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImageUser = document.getElementById('previewImagePopup');
            previewImageUser.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
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
<script src="js/jquery.min.js"></script>
<script src="js/adminlte.min.js"></script>
<!-- Add & Delete Input -->
<script>
$(document).ready(function() {
    var count = 1; // ตัวแปรนับค่าชื่อ name
    $('#addButton').click(function() {
        var formGroup = $('<div class="form-group">' +
            '<textarea name="Games[]" class="form-control border-0 my-2" placeholder="iframe" style="height: 110px;"></textarea>' +
            '</div>');
        $('#form-container').append(formGroup);
    });

    $('#deleteButton').click(function() {
        $('#form-container .form-group:last-child').remove();
        count--; // ลดค่านับเมื่อกดปุ่ม "ลบ"
    });
    
    $('#addButtonMasterMenuCategory').click(function() {
        var formGroup = $('<div class="row my-3">' +
                    '<div class="col-11">' +
                    '<input type="hidden" name="mcinputcode[]" class="form-control">' +
                    '<input type="text" name="mcinputname[]" class="form-control">' +
                    '</div>' +
                    '<div class="col-1">' +
                    '</div>' +
                    '</div>');
        $('#modalContentMasterMenuCategory').append(formGroup);
    });

    $('#addButtonGeneralSettings').click(function() {
        var formGroup = $('<div class="row my-3">' +
                    '<div class="col-4">' +
                    '<input type="hidden" name="inputcode[]" class="form-control">' +
                    '<input type="text" name="inputname[]" class="form-control">' +
                    '</div>' +
                    '<div class="col-5">' +
                    '<input type="text" name="inputvalue[]" class="form-control">' +
                    '</div>' +
                    '<div class="col-2">' +
                    '<input class="form-control" name="inputvaluefile[]" type="file" accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx">' +
                    '</div>' +
                    '<div class="col-1">' +
                    '</div>' +
                    '</div>');
        $('#modalContent').append(formGroup);
    });

    $('#addButtonMenu').click(function() {
        var formGroup = $('<div class="row g-2 my-2 col-12 dynamic-content">' + 
                    '<input type="hidden" name="PM_Code[]" value="0" class="form-control">' +
                    '<div class="col-3 col-sm-3">' +
                    '<h6 class="text-primary">ชื่อ</h6>' +
                    '<input type="Text" id="PM_Name" name="PM_Name[]" class="form-control border-1" placeholder="ชื่อหัวข้อ" required>' +
                    '</div>' +
                    '<div class="col-2 col-sm-2">' +
                    '<h6 class="text-primary">ประเภท</h6>' +
                    '<select class="form-select border-1 pm-relation-type" id="PM_RelationType" name="PM_RelationType[]" required>' +
                    '<option value="NoType">ไม่มีประเภท</option>' +
                    '<option value="Category">Category</option>' +
                    '<option value="HeadingCategories">HeadingCategories</option>' +
                    '<option value="EngravedCategory">EngravedCategory</option>' +
                    '<option value="SetupGames">SetupGames</option>' +
                    '<option value="Setup">Setup</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-2 col-sm-2 dynamic-select-container" id="dynamicSelectContainer">' +
                    '<h6 class="text-primary">หน้า</h6>' +
                    '<select class="form-select border-1 pm-relation-code" id="PM_RelationCode" name="PM_RelationCode[]">' +
                    '<option value="NoType">ไม่มีข้อมูล</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1">' +
                    '<h6 class="text-primary">ทิศทาง</h6>' +
                    '<select class="form-select border-1" id="PM_Direction" name="PM_Direction[]" required>' +
                    '<option value="left">ซ้าย</option>' +
                    '<option value="right">ขวา</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1 text-center">' +
                    '<h6 class="text-primary">เส้นขั้น</h6>' +
                    '<select class="form-select border-1" id="PM_Draw" name="PM_Draw[]" required>' +
                    '<option value="0">ไม่มี</option>' +
                    '<option value="1">มี</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1 text-center">' +
                    '<h6 class="text-primary">เส้นขั้น</h6>' +
                    '<select class="form-select border-1" id="PM_Setup" name="PM_Setup[]" required>' +
                    '<option value="0">ไม่มี</option>' +
                    '<option value="1">มี</option>' +
                    '</select>' +
                    '</div>' +
                    // '<div class="col-1 col-sm-1 text-center">' +
                    // '<h6 class="text-primary">เพิ่มขั้น</h6>' +
                    // '<button type="button" class="btn btn-link py-1 px-2 text-end text-danger" data-bs-toggle="modal" data-bs-target="#"></button>' +
                    // '</div>' +
                    // '<div class="col-1 col-sm-1 text-center">' +
                    // '<h6 class="text-primary">ตำแหน่ง</h6>' +
                    // '<button type="button" class="btn btn-link py-1 px-2 text-end text-danger" data-bs-toggle="modal" data-bs-target="#"></button>' +
                    // '</div>' +
                    '<div class="col-2 col-sm-2 text-center">' +
                    '<h6 class="text-primary">จัดการ</h6>' +
                    '<button type="button" class="btn btn-link py-1 px-2 text-end text-danger btn-delete-row"><i class="fa fa-trash"></i></button>' +
                    '</div>' +
                    '</div>');
        $('#modalContentMenu').append(formGroup);
    });
    $(document).on('click', '.btn-delete-row', function() {
        $(this).closest('.dynamic-content').remove();
    });

    $('#addButtonMenuSub2').click(function() {
        var formGroup = $('<div class="row g-2 my-2 col-12 dynamic2-content">' + 
                    '<input type="hidden" name="PM_Code[]" value="0" class="form-control">' +
                    '<div class="col-3 col-sm-3">' +
                    '<h6 class="text-primary">ชื่อ</h6>' +
                    '<input type="Text" id="PM_Name" name="PM_Name[]" class="form-control border-1" placeholder="ชื่อหัวข้อ" required>' +
                    '</div>' +
                    '<div class="col-2 col-sm-2">' +
                    '<h6 class="text-primary">ประเภท</h6>' +
                    '<select class="form-select border-1 pm-relation-type" id="PM_RelationType" name="PM_RelationType[]" required>' +
                    '<option value="NoType">ไม่มีประเภท</option>' +
                    '<option value="Category">Category</option>' +
                    '<option value="HeadingCategories">HeadingCategories</option>' +
                    '<option value="EngravedCategory">EngravedCategory</option>' +
                    '<option value="SetupGames">SetupGames</option>' +
                    '<option value="Setup">Setup</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-2 col-sm-2 dynamic-select-container" id="dynamicSelectContainer">' +
                    '<h6 class="text-primary">หน้า</h6>' +
                    '<select class="form-select border-1 pm-relation-code" id="PM_RelationCode" name="PM_RelationCode[]">' +
                    '<option value="NoType">ไม่มีข้อมูล</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1">' +
                    '<h6 class="text-primary">ทิศทาง</h6>' +
                    '<select class="form-select border-1" id="PM_Direction" name="PM_Direction[]" required>' +
                    '<option value="left">ซ้าย</option>' +
                    '<option value="right">ขวา</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1 text-center">' +
                    '<h6 class="text-primary">เส้นขั้น</h6>' +
                    '<select class="form-select border-1" id="PM_Draw" name="PM_Draw[]" required>' +
                    '<option value="0">ไม่มี</option>' +
                    '<option value="1">มี</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1 text-center">' +
                    '<h6 class="text-primary">เพิ่มขั้น</h6>' +
                    // '<button type="button" class="btn btn-link py-1 px-2 text-end text-danger" data-bs-toggle="modal" data-bs-target="#"></button>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1 text-center">' +
                    '<h6 class="text-primary">ตำแหน่ง</h6>' +
                    // '<button type="button" class="btn btn-link py-1 px-2 text-end text-danger" data-bs-toggle="modal" data-bs-target="#"></button>' +
                    '</div>' +
                    '<div class="col-1 col-sm-1 text-center">' +
                    '<h6 class="text-primary">ลบ</h6>' +
                    '<button type="button" class="btn btn-link py-1 px-2 text-end text-danger btn-delete-row2"><i class="fa fa-trash"></i></button>' +
                    '</div>' +
                    '</div>');
        $('#modalContentMenu2').append(formGroup);
    });
    $(document).on('click', '.btn-delete-row2', function() {
        $(this).closest('.dynamic2-content').remove();
    });
});
</script>
<!-- category Delete -->
<script>    
    function deleteAlertCategory(categoryID, categoryName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${categoryName}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteCategory.php?Send_ID=${categoryID}&Send_Name=${categoryName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertMenuCategory(categoryID, categoryText,SendType) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${categoryText}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteMenuCategory.php?Send_ID=${categoryID}&Send_Text=${categoryText}&Send_Type=${SendType}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertMasterMenuCategory(MasterMenuCategoryID, MasterMenuCategoryName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${MasterMenuCategoryName}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteMasterMenuCategory.php?Send_ID=${MasterMenuCategoryID}&Send_Name=${MasterMenuCategoryName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertEngravedCategory(EngravedCategoryID, EngravedCategoryName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${EngravedCategoryName}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteEngravedCategory.php?Send_ID=${EngravedCategoryID}&Send_Name=${EngravedCategoryName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertEngravedActivities(EngravedActivitiesID, EngravedActivitiesName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${EngravedActivitiesName}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteEngravedActivities.php?Send_ID=${EngravedActivitiesID}&Send_Name=${EngravedActivitiesName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertUser(UserID) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${UserID}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteUser.php?Send_ID=${UserID}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertPosition(PositionID, PositionName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${PositionName} เมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeletePosition.php?Send_ID=${PositionID}&Send_Name=${PositionName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertMenu(MenuID, MenuName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${MenuName} เมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteMenu.php?Send_ID=${MenuID}&Send_Name=${MenuName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertMenuSub(MenuSubID, MenuSubName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${MenuSubName} เมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeleteMenuSub.php?Send_ID=${MenuSubID}&Send_Name=${MenuSubName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
    function deleteAlertPopup(PopupID,PopupName) {
        swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${PopupID}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "ยกเลิก",
                    value: false,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "ลบ",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                window.location.replace(`Pro_DeletePopup.php?Send_ID=${PopupID}&Send_Name=${PopupName}`);
            } else {
                // เมื่อกดยกเลิก ไม่ต้องทำอะไร
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
</script>
<!-- category Edit -->
<script>
    // เมื่อ Modal Category ถูกเปิดขึ้นมา
    $('#Category').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const entityNo = button.data('entityno');
        const entityRelationNo = button.data('entityrelationno');
        const isfile = button.data('isfile');
        const name = button.data('name');
        const descriptionTH = button.data('descriptionth');
        const descriptionEN = button.data('descriptionen');
        const ecImage = button.data('ecimage') !== '' ? 'img/DefaultImageCategory/' + button.data('ecimage') : 'Default/DefaultImage/DefaultImage.png';
        const oldImage = button.data('ecimage');


        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("CG_EntityNo").value = entityNo;
        document.getElementById("CG_EntityRelationNo").value = entityRelationNo;
        document.getElementById("CG_IsFile").checked = (isfile == 1);
        document.getElementById("CG_Name").value = name;
        document.getElementById("CG_DescriptionTH").value = descriptionTH;
        document.getElementById("CG_DescriptionEN").value = descriptionEN;
        document.getElementById("CG_OldImage").value = oldImage;

        var modalContentMasterMenuCategory = document.getElementById("modalPreviewImageCategory");
        var contentHTML = '<img id="previewImageCategory" class="img-fluid rounded" src="' + ecImage + '" alt="" style="width: 200px; height: 200px;">';
        modalContentMasterMenuCategory.innerHTML = contentHTML;
    });

    // เมื่อ Modal MenuCategory ถูกเปิดขึ้นมา
    $('#MenuCategory').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const hcCode = button.data('hccode');
        const hcText = button.data('hctext');
        const hcDescriptionTH = button.data('hcdescriptionth');
        const hcDescriptionEN = button.data('hcdescriptionen');
        const hcImage = button.data('hcimage') !== '' ? 'img/DefaultImageHeadingCategory/' + button.data('hcimage') : 'Default/DefaultImage/DefaultImage.png';
        const hcOldImage = button.data('hcimage');

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("Send_Code").value = hcCode;
        document.getElementById("Send_Text").value = hcText;
        document.getElementById("Send_descriptionth").value = hcDescriptionTH;
        document.getElementById("Send_descriptionen").value = hcDescriptionEN;
        document.getElementById("Send_OldImage").value = hcOldImage;

        var modalContentMasterMenuCategory = document.getElementById("modalPreviewImageMenuCategory");
        var contentHTML = '<img id="previewImageMenuCategory" class="img-fluid rounded" src="' + hcImage + '" alt="" style="width: 200px; height: 200px;">';
        modalContentMasterMenuCategory.innerHTML = contentHTML;
    });

    // เมื่อ Modal MasterMenuCategory ถูกเปิดขึ้นมา
    $('#MasterMenuCategory').on('show.bs.modal', function(event) {
        var hcCode = event.relatedTarget.dataset.hccode;
        // console.log(hcCode);
        // ส่งค่าตัวกรองไปยังหน้า PHP ดึงข้อมูล
        $.ajax({
            url: "DB_MasterMenuCategory.php",
            type: "POST",
            data: { hccode: hcCode },
            dataType: "json",
            success: function(response) {
                // ดำเนินการแสดงผลข้อมูลที่ได้รับใน Modal
                var modalContentMasterMenuCategory = document.getElementById("modalContentMasterMenuCategory");
                var contentHTML = '<input type="hidden" name="inputMastercode" value="' + hcCode + '" class="form-control">';

                // ใช้ Loop เพื่อแสดงข้อมูลใน Modal
                for (var i = 0; i < response.length; i++) {
                    contentHTML +=
                        '<div class="row my-3">' +
                        '<div class="col-11">' +
                        '<input type="hidden" name="mcinputcode[]" value="' + response[i].MC_Code + '" class="form-control">' +
                        '<input type="text" name="mcinputname[]" value="' + response[i].MC_Text + '" class="form-control">' +
                        '</div>' +
                        '<div class="col-1">' +
                        '<button type="button" class="btn btn-danger rounded-pill py-1 px-2 add-image-btn text-end" onclick="deleteAlertMasterMenuCategory(\'' + response[i].MC_Code + '\', \'' + response[i].MC_Text + '\')"><i class="fas fa-trash"></i></button>' +
                        '</div>' +
                        '</div>';
                }
                modalContentMasterMenuCategory.innerHTML = contentHTML;
            },
            error: function() {
                console.log("เกิดข้อผิดพลาดกับการเชื่อมต่อ");
            }
        });
    });

    // เมื่อ Modal EngravedCategory ถูกเปิดขึ้นมา
    $('#engravedcategory').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const ecCode = button.data('eccode');
        const ecName = button.data('ecname');
        const ecDescriptionTH = button.data('ecdescriptionth');
        const ecDescriptionEN = button.data('ecdescriptionen');

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("EC_code").value = ecCode;
        if (ecName === undefined) {
            document.getElementById("EC_name").value = '';
        } else {
            document.getElementById("EC_name").value = ecName;
        }
        document.getElementById("EC_descriptionth").value = ecDescriptionTH;
        document.getElementById("EC_descriptionen").value = ecDescriptionEN;      
    });

    // เมื่อ Modal EngravedActivities ถูกเปิดขึ้นมา
    $('#EngravedActivities').on('show.bs.modal', function(event) {
        var ecCode = event.relatedTarget.dataset.eccode;
        // ส่งค่าตัวกรองไปยังหน้า PHP ดึงข้อมูล
        $.ajax({
            url: "DB_EngravedActivities.php",
            type: "POST",
            data: { eccode: ecCode },
            dataType: "json",
            success: function(response) {
                // ดำเนินการแสดงผลข้อมูลที่ได้รับใน Modal
                var modalContent = document.getElementById("modalContent");
                var contentHTML = '<input type="hidden" name="inputMastercode" value="' + ecCode + '" class="form-control">';

                // ใช้ Loop เพื่อแสดงข้อมูลใน Modal
                for (var i = 0; i < response.length; i++) {
                    contentHTML +=
                        '<div class="row my-3">' +
                        '<div class="col-4">' +
                        '<input type="hidden" name="inputcode[]" value="' + response[i].EA_Code + '" class="form-control">' +
                        '<input type="text" name="inputname[]" value="' + response[i].EA_Name + '" class="form-control">' +
                        '</div>' +
                        '<div class="col-5">' +
                        '<input type="text" name="inputvalue[]" value="' + response[i].EA_Path + '" class="form-control">' +
                        '</div>' +
                        '<div class="col-2">' +
                        '<input class="form-control" name="inputvaluefile[]" type="file" accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx">' +
                        '</div>' +
                        '<div class="col-1">' +
                        '<button type="button" class="btn btn-danger rounded-pill py-1 px-2 add-image-btn text-end" onclick="deleteAlertEngravedActivities(\'' + response[i].EA_Code + '\', \'' + response[i].EA_Name + '\')"><i class="fas fa-trash"></i></button>' +
                        '</div>' +
                        '</div>';
                }
                modalContent.innerHTML = contentHTML;
            },
            error: function() {
                console.log("เกิดข้อผิดพลาดกับการเชื่อมต่อ");
            }
        });
    });

    // เมื่อ Modal User ถูกเปิดขึ้นมา
    $('#modaluser').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const usType = button.data('ustype');
        const usUsername = button.data('ususername');
        const usPassword = button.data('uspassword');
        const usPrefix = button.data('usprefix');
        const ptCode = button.data('ptcode');
        const usFname = button.data('usfname');
        const usLname = button.data('uslname');
        const usImage = button.data('usimage') !== '' ? 'img/User/' + button.data('usimage') : 'Default/DefaultUser/0.png';
        const usOldImage = button.data('usimage');

        // console.log(usPrefix);

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("US_Type").value = usType;
        document.getElementById("US_Username").value = usUsername;
        document.getElementById("US_Password").value = usPassword;
        document.getElementById("US_Prefix").value = usPrefix;
        document.getElementById("PT_Code").value = ptCode;
        if (usFname === undefined) {
            document.getElementById("US_Fname").value = '';
        } else {
            document.getElementById("US_Fname").value = usFname;
        }
        if (usLname === undefined) {
            document.getElementById("US_Lname").value = '';
        } else {
            document.getElementById("US_Lname").value = usLname;
        }
        document.getElementById("US_Image").value = usOldImage;

        var modalContentMasterMenuUser = document.getElementById("modalPreviewImageUser");
        var contentHTML = '<img id="previewImageUser" class="img-fluid rounded" src="' + usImage + '" alt="" style="width: 50px; height: 50px;">';
        modalContentMasterMenuUser.innerHTML = contentHTML;
    });

    // เมื่อ Modal Position ถูกเปิดขึ้นมา
    $('#modalposition').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const ptCode = button.data('ptcode');
        const ptName = button.data('ptname');

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("PT_code").value = ptCode;
        if (ptName === undefined) {
            document.getElementById("PT_name").value = '';
        } else {
            document.getElementById("PT_name").value = ptName;
        }
    });

    // เมื่อ Modal Menu ถูกเปิดขึ้นมา
    $('#modalmenu').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const mnCode = button.data('mncode');
        const mnName = button.data('mnname');

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("MN_Code").value = mnCode;
        document.getElementById("MN_Name").value = mnName;
    });

    // เมื่อ Modal Menu ถูกเปิดขึ้นมา
    $('#modalmenusub').on('show.bs.modal', function(event) {
        $('.dynamic-content').empty();
        const button = $(event.relatedTarget);
        const mnCodeSub = button.data('mncodesub');
        const pmType = button.data('pmtype');

        // ส่งค่าตัวกรองไปยังหน้า PHP ดึงข้อมูล
        $.ajax({
            url: "DB_SubMenu.php",
            type: "POST",
            data: { pmcode: mnCodeSub, pmtype: pmType},
            dataType: "json",
            success: function(response) {
                // ดำเนินการแสดงผลข้อมูลที่ได้รับใน Modal
                var modalContentMenuDB = document.getElementById("modalContentMenuDB");
                var contentHTML = '<input type="hidden" name="MN_CodeSub" value="' + mnCodeSub + '" class="form-control">';
                contentHTML += '<input type="hidden" name="PM_Type" value="' + pmType + '" class="form-control">';

                // ใช้ Loop เพื่อแสดงข้อมูลใน Modal
                for (var i = 0; i < response.length; i++) {
                    contentHTML +=
                        '<div class="row g-2 my-2 col-12 dynamic-content">' +
                        '<input type="hidden" name="PM_Code[]" value="' + response[i].PM_Code + '" class="form-control">' +
                        '<div class="col-3 col-sm-3">' +
                        '<h6 class="text-primary">ชื่อ</h6>' +
                        '<input type="Text" id="PM_Name" name="PM_Name[]" class="form-control border-1" value="' + response[i].PM_Name + '" placeholder="ชื่อหัวข้อ" required>' +
                        '</div>' +
                        '<div class="col-2 col-sm-2">' +
                        '<h6 class="text-primary">ประเภท</h6>' +
                        '<select class="form-select border-1 pm-relation-type" id="PM_RelationType" name="PM_RelationType[]" required>' +
                        '<option value="NoType" ' + (response[i].PM_RelationType === '' ? 'selected' : '') + '>ไม่มีประเภท</option>' +
                        '<option value="Category" ' + (response[i].PM_RelationType === 'Category' ? 'selected' : '') + '>Category</option>' +
                        '<option value="HeadingCategories" ' + (response[i].PM_RelationType === 'HeadingCategories' ? 'selected' : '') + '>HeadingCategories</option>' +
                        '<option value="EngravedCategory" ' + (response[i].PM_RelationType === 'EngravedCategory' ? 'selected' : '') + '>EngravedCategory</option>' +
                        '<option value="SetupGames" ' + (response[i].PM_RelationType === 'SetupGames' ? 'selected' : '') + '>SetupGames</option>' +
                        '<option value="Setup" ' + (response[i].PM_RelationType === 'Setup' ? 'selected' : '') + '>Setup</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-2 col-sm-2 dynamic-select-container">' +
                        '<h6 class="text-primary">หน้า</h6>' +
                        '<select class="form-select border-1 pm-relation-code" name="PM_RelationCode[]" required>';
                       if (response[i].dataFromDBSub.length === 0) {
                            contentHTML += '<option value="0" selecte>ไม่มีข้อมูล</option>';
                       } else {
                            for (var x = 0; x < response[i].dataFromDBSub.length; x++) {
                                contentHTML +=
                                    '<option value="' + response[i].dataFromDBSub[x].SubCode + '" ' + (response[i].dataFromDBSub[x].SubCode === response[i].PM_RelationCode ? 'selected' : '') + '>' +
                                    response[i].dataFromDBSub[x].Subname +
                                    '</option>';
                            }
                       }
                    contentHTML +=
                        '</select>' +
                        '</div>' +
                        '<div class="col-1 col-sm-1">' +
                        '<h6 class="text-primary">ทิศทาง</h6>' +
                        '<select class="form-select border-1" id="PM_Direction" name="PM_Direction[]" required>' +
                        '<option value="left" ' + (response[i].PM_Direction === 'left' ? 'selected' : '') + '>ซ้าย</option>' +
                        '<option value="right" ' + (response[i].PM_Direction === 'right' ? 'selected' : '') + '>ขวา</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-1 col-sm-1 text-center">' +
                        '<h6 class="text-primary">เส้นขั้น</h6>' + 
                        '<select class="form-select border-1" id="PM_Draw" name="PM_Draw[]" required>' +
                        '<option value="0" ' + (response[i].PM_Draw == 0 ? 'selected' : '') + '>ไม่มี</option>' +
                        '<option value="1" ' + (response[i].PM_Draw == 1 ? 'selected' : '') + '>มี</option>' +
                        '</select>' +                       
                        '</div>' +
                        '<div class="col-1 col-sm-1 text-center">' +
                        '<h6 class="text-primary">ตั้งค่า</h6>' + 
                        '<select class="form-select border-1" id="PM_Setup" name="PM_Setup[]" required>' +
                        '<option value="0" ' + (response[i].PM_Setup == 0 ? 'selected' : '') + '>ไม่มี</option>' +
                        '<option value="1" ' + (response[i].PM_Setup == 1 ? 'selected' : '') + '>มี</option>' +
                        '</select>' +                       
                        '</div>' +
                        // '<div class="col-1 col-sm-1 text-center">' +
                        // '<h6 class="text-primary">เพิ่มขั้น</h6>' +
                        // '<button type="button" class="btn btn-link py-1 px-2 text-end text-primary" data-bs-toggle="modal" data-bs-target="#modalmenusub2" data-mncodesub="' + response[i].PM_Code + '" data-pmtype="submenu"><i class="fa fa-plus"></i></button>' +
                        // '</div>' +
                        // '<div class="col-1 col-sm-1 text-center">' +
                        // '<h6 class="text-primary">ตำแหน่ง</h6>' +
                        // '<button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#modalmenusub"><i class="fa fa-address-book"></i></button>' +
                        // '</div>' +
                        '<div class="col-2 col-sm-2 text-center">' +
                        '<h6 class="text-primary">จัดการ</h6>' +
                        '<button type="button" class="btn btn-link py-1 px-2 text-end text-primary" data-bs-toggle="modal" data-bs-target="#modalmenusub2" data-mncodesub="' + response[i].PM_Code + '" data-pmtype="submenu"><i class="fa fa-plus"></i></button>' +
                        '<button type="button" class="btn btn-link py-1 px-2 text-end text-warning" data-bs-toggle="modal" data-bs-target="#modalmenusub"><i class="fa fa-address-book"></i></button>' +
                        '<a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertMenuSub(' + response[i].PM_Code + ', \'' + response[i].PM_Name + '\')"><i class="fas fa-trash"></i></a>' +
                        '</div>' +
                        '</div>';
                }
                modalContentMenuDB.innerHTML = contentHTML;
            },
            error: function() {
                console.log("เกิดข้อผิดพลาดกับการเชื่อมต่อ");
            }
        });
    });

    // เมื่อ Modal Popup ถูกเปิดขึ้นมา
    $('#modalpopup').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const apCode = button.data('apcode');
        const apName = button.data('apname');
        const apImage = button.data('apimage') !== '' ? 'img/Popup/' + button.data('apimage') : 'Default/DefaultImage/DefaultImage.png';
        const apOldImage = button.data('apimage');
        const apDateStart = button.data('apdatestart');
        const apDateEnd = button.data('apdateend');

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("AP_Code").value = apCode;
        if (apName === undefined) {
            document.getElementById("AP_Name").value = '';
        } else {
            document.getElementById("AP_Name").value = apName;
        }
        document.getElementById("AP_OldImage").value = apOldImage;
        document.getElementById("AP_DateStart").value = apDateStart;
        document.getElementById("AP_DateEnd").value = apDateEnd;

        var modalContentMasterMenuPopup = document.getElementById("modalPreviewImagePopup");
        var contentHTML = '<img id="previewImagePopup" class="img-fluid rounded" src="' + apImage + '" alt="" style="width: 200px; height: 200px;">';
        modalContentMasterMenuPopup.innerHTML = contentHTML;
    });    
</script>
<!-- Hidden -->
<script>
// ดักจับเหตุการณ์คลิกที่ปุ่มที่มีคลาส toggleButton
const toggleButtons = document.querySelectorAll(".toggleButton");
toggleButtons.forEach(button => {
  button.addEventListener("click", function() {
    const icon = this.querySelector("i");
    let sendStatus; // ประกาศตัวแปร sendStatus ที่เห้นใช้ได้ทั่วกับทุกส่วนของฟังก์ชัน
    if (icon.classList.contains("fa-eye")) {
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
      sendStatus = 0; // กำหนดค่าให้กับตัวแปร sendStatus
    } else if (icon.classList.contains("fa-eye-slash")){
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
      sendStatus = 1; // กำหนดค่าให้กับตัวแปร sendStatus
    }
    const sendID = this.getAttribute("data-sendHiddenID");
    sendDataToPHP(sendStatus, sendID); // ส่งค่าไปยัง PHP
  });
});

function sendDataToPHP(status, id) {
  // ส่งข้อมูลไปยัง PHP โดยใช้ AJAX
  const xhr = new XMLHttpRequest();
  const url = "DB_UserHidden.php"; // เปลี่ยนเป็นชื่อไฟล์ PHP ที่คุณต้องการใช้งาน
  const params = "status=" + status + "&id=" + id; // ส่งค่าตัวแปรไปยัง PHP
  console.log(params);
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // ทำสิ่งที่คุณต้องการหลังจากที่ส่งข้อมูลเสร็จสิ้น (หากต้องการ)
      console.log(xhr.responseText); // ตัวอย่างการแสดงผล response ที่ได้จาก PHP
    }
  };
  xhr.send(params);
}

// ดักจับเหตุการณ์คลิกที่ปุ่มที่มีคลาส toggleButtonPopup
const toggleButtonsUser = document.querySelectorAll(".toggleButtonPopup");
toggleButtonsUser.forEach(button => {
  button.addEventListener("click", function() {
    const iconPopup = this.querySelector("i");
    let sendStatusPopup; // ประกาศตัวแปร sendStatusPopup ที่เห้นใช้ได้ทั่วกับทุกส่วนของฟังก์ชัน
    if (iconPopup.classList.contains("fa-eye")) {
      iconPopup.classList.remove("fa-eye");
      iconPopup.classList.add("fa-eye-slash");
      sendStatusPopup = 0; // กำหนดค่าให้กับตัวแปร sendStatusPopup
    } else if (iconPopup.classList.contains("fa-eye-slash")){
      iconPopup.classList.remove("fa-eye-slash");
      iconPopup.classList.add("fa-eye");
      sendStatusPopup = 1; // กำหนดค่าให้กับตัวแปร sendStatusPopup
    }
    const sendPopupID = this.getAttribute("data-sendHiddenPopupID");
    sendDataToPopupPHP(sendStatusPopup, sendPopupID); // ส่งค่าไปยัง PHP
  });
});

function sendDataToPopupPHP(status, id) {
  // ส่งข้อมูลไปยัง PHP โดยใช้ AJAX
  const xhr = new XMLHttpRequest();
  const url = "DB_PopupHidden.php"; // เปลี่ยนเป็นชื่อไฟล์ PHP ที่คุณต้องการใช้งาน
  const params = "status=" + status + "&id=" + id; // ส่งค่าตัวแปรไปยัง PHP
  console.log(params);
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // ทำสิ่งที่คุณต้องการหลังจากที่ส่งข้อมูลเสร็จสิ้น (หากต้องการ)
      console.log(xhr.responseText); // ตัวอย่างการแสดงผล response ที่ได้จาก PHP
    }
  };
  xhr.send(params);
}
</script>
<?php include("Fn_IndexSetup.php"); ?>
<!-- Menu -->
<script>
$(document).ready(function() {
    function handleRelationTypeChange(selectElement) {
        const selectedType = selectElement.val();
        const dynamicSelectContainer = selectElement.closest('.dynamic-content').find('.dynamic-select-container');

        if (selectedType) {
            $.ajax({
                url: 'DB_GetPermissionMenu.php',
                method: 'POST',
                data: { type: selectedType },
                success: function(response) {
                    const title = $('<h6 class="text-primary">หน้า</h6>');
                    const select = $('<select>', { class: 'form-select border-1 pm-relation-code', name: 'PM_RelationCode[]' });
                    if (response.length === 0) {
                        select.append($('<option>', { value: 0, text: 'ไม่มีข้อมูล' }));
                    } else {
                        response.forEach(function(item) {
                            select.append($('<option>', { value: item.id, text: item.name }));
                        });
                    }
                    dynamicSelectContainer.empty().append(title, select);
                },
                error: function(xhr, status, error) {
                    console.error('Ajax request error:', error);
                }
            });
        } else {
            dynamicSelectContainer.empty();
        }
    }

    $(document).on('change', '.pm-relation-type', function() {
        handleRelationTypeChange($(this));
    });
});

</script>
<?php include("Ma_Footer_Script.php"); ?>