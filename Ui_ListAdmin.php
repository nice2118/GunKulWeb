<?php 
include("DB_Include.php"); 
if (isset($_GET['Send_Category']) && $_GET['Send_Category'] !== '') {
    $Category_id = $_GET['Send_Category'];
    $_SESSION['PathPage'] = "ListAdmin?Send_Category=".$Category_id;
} else {
    $Category_id = 1;
}
?>

<?php include("Fn_RecursiveCategory.php"); ?>
<?php include("Ma_Head_Link.php"); ?>
<!-- Icon Font Stylesheet -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<?php include("Ma_Head.php"); ?>
<?php include("Ma_Carousel.php"); ?>

<?php
    $CheckPage = false;
    $sql = "SELECT * FROM `permissionmenu` WHERE `permissionmenu`.`PM_RelationType` = 'Category' AND `permissionmenu`.`PM_RelationCode` = '$Category_id' AND `permissionmenu`.`PM_Setup` = '1';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (CheckStatus($globalCurrentUser, $row["PM_Code"])) {
                $CheckPage = true;
            }
        }
    }
    if (!$CheckPage) {
        echo "<script>setTimeout(function() { window.location.href = `./Index`; }, 0); </script>";
    }
?>

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
                        $IsFile = $row["CG_IsFile"];
                    }
                ?>
                <h3 class="text-primary mb-0 mt-0"><?= $DescriptionEN ?></h3>
                <h2 class="mb-0 mt-0"><?= $DescriptionTH ?></h2>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <div class="d-flex align-items-center">
                    <?php if ($IsFile == 0): ?>
                    <a class="small fw-medium" href="Add?Send_Category=<?= $Category_id ?>">
                    <?php elseif ($IsFile == 1): ?>
                    <a class="small fw-medium" href="AddFile?Send_Category=<?= $Category_id ?>">
                    <?php endif; ?>
                        <div class="d-flex align-items-center">
                            <div class="btn-lg-square bg-primary rounded-circle">
                                <i class="fa fa-plus text-white"></i>
                            </div>
                            <div class="ms-2">
                                <h6 class="small text-primary mb-0 mt-0">Add <?= $DescriptionEN ?></h6>
                                <h5 class="mb-0 mt-0">เพิ่ม<?= $DescriptionTH ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-4">
                <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div style="overflow:auto;">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-striped projects">
                                    <thead>
                                    <tr>
                                    <th>วันที่ลง </th>
                                    <th>ประเภท</th>
                                    <th>หัวเรื่อง</th>
                                    <th>เนื่อหาโดยย่อ</th>
                                    <th>เจ้าของ</th>
                                    <th>สถานะ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $SelectFilterCategoryEntityNo = SearchCategory($Category_id);
                                        if ($IsFile == 0):
                                            $sql = "SELECT * FROM `Activities` LEFT JOIN `user` ON `Activities`.`AT_UserCreate` = `User`.`US_Username` LEFT JOIN `Category` ON `Activities`.`AT_Entity No.` = `Category`.`CG_Entity No.` WHERE (`Activities`.`AT_Entity No.` IN ($SelectFilterCategoryEntityNo)) ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC;";
                                        elseif ($IsFile == 1):
                                            $sql = "SELECT * FROM `FileActivities` LEFT JOIN `user` ON `FileActivities`.`FA_UserCreate` = `User`.`US_Username` LEFT JOIN `Category` ON `FileActivities`.`FA_Entity No.` = `Category`.`CG_Entity No.` WHERE (`FileActivities`.`FA_Entity No.` IN ($SelectFilterCategoryEntityNo)) ORDER BY `FileActivities`.`FA_Date` DESC , `FileActivities`.`FA_Time` DESC;";
                                        endif;
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $reqCode = 0;
                                                $reqDate = '';
                                                $reqTitle = '';
                                                $reqDescription = '';
                                                $reqFile = '';
                                                $fullName = '';
                                                $imgShow = '';
                                                $reqType = '';
                                                $UserCreate = '';
                                                $Active = 0;
                                                if ($IsFile == 0){
                                                    $reqCode = $row['AT_Code'];
                                                    $reqDate = $row['AT_Date'];
                                                    $reqTitle = $row['AT_Title'];
                                                    $reqDescription = $row['AT_Description'];
                                                    $fullName = $row['US_Fname'];
                                                    $reqType= $row['CG_DescriptionTH'];
                                                    $UserCreate = $row['AT_UserCreate'];
                                                    $Active = $row['AT_Active'];
                                                } elseif ($IsFile == 1) {
                                                    $reqCode = $row['FA_Code'];
                                                    $reqDate = $row['FA_Date'];
                                                    $reqTitle = $row['FA_Title'];
                                                    $reqDescription = $row['FA_Description'];
                                                    $fullName = $row['US_Fname'];
                                                    $reqType= $row['CG_DescriptionTH'];
                                                    $UserCreate = $row['FA_UserCreate'];
                                                    $Active = $row['FA_Active'];
                                                    
                                                    $sqlSetup = "SELECT * FROM Setup";
                                                    $resultSetup = $conn->query($sqlSetup);
                                                    if ($resultSetup->num_rows > 0) {
                                                        $rowSetup = $resultSetup->fetch_assoc();
                                                        $reqFile = $rowSetup['SU_PathDefaultFile'].$row['FA_File'];
                                                    }
                                                    
                                                }
                                                if ($row['US_Image'] != ''){
                                                    $imgShow = 'img/User/'.$row['US_Image'];
                                                }
                                                if ($imgShow == '') {
                                                    $imgShow = 'Default/DefaultUser/0.png';
                                                }
                                        ?>
                                        <tr>
                                            <td><?php echo $reqDate; ?></td>
                                            <td><?php echo $reqType; ?></td>
                                            <td><?php echo $reqTitle; ?></td>
                                            <td>
                                                <!-- <div class="col-10 text-truncate"> -->
                                                    <?php echo $reqDescription; ?>
                                                <!-- </div> -->
                                                <!-- <div class="progress progress-sm">
                                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%">
                                                    </div>
                                                </div>
                                                <small>
                                                    35% Complete
                                                </small> -->
                                            </td>
                                            <td>
                                            <img class="img-fluid rounded-circle mx-1 mb-1" src="<?=$imgShow?>" alt="User Image" style="width: 40px; height: 40px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $fullName;?>">
                                            </td>
                                            <td class="project-actions text-right">
                                                <?php if ($IsFile == 0): ?>
                                                    <?php
                                                        if (CheckAdmin($globalCurrentUser) || CheckManage($globalCurrentUser)){
                                                            if ($Active == 1) {
                                                                echo '<a class="btn btn-secondary btn-sm toggleButton" id="toggleButton1" data-sendHiddenID="' . $reqCode . '" data-sendIsFile="' . $IsFile . '"><i class="fas fa-eye"></i></a>';
                                                            } else {
                                                                echo '<a class="btn btn-secondary btn-sm toggleButton" id="toggleButton0" data-sendHiddenID="' . $reqCode . '" data-sendIsFile="' . $IsFile . '"><i class="fas fa-eye-slash"></i></a>';
                                                            }
                                                        }
                                                    ?>
                                                    <a class="btn btn-primary2 btn-sm" href="ShowDetail?Send_IDNews=<?= $reqCode;?>"><i class="fas fa-folder"></i></a>
                                                    <?php if ($UserCreate == $globalCurrentUser || CheckAdmin($globalCurrentUser) || CheckManage($globalCurrentUser)){ ?>
                                                        <a class="btn btn-warning btn-sm" href="Edit?Send_IDNews=<?= urlencode($reqCode); ?>&Send_Title=<?= urlencode($reqTitle); ?>&Send_Category=<?= $Category_id ; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                        <a class="btn btn-danger btn-sm" onclick="deleteAlert(<?php echo $reqCode;?>, '<?= addslashes(htmlspecialchars_decode($reqTitle, ENT_QUOTES)) ?>',<?php echo $Category_id;?>)"><i class="fas fa-trash"></i></a>
                                                    <?php }  ?>
                                                <?php elseif ($IsFile == 1): ?>
                                                    <a class="btn btn-primary2 btn-sm" id="btnShowFile" href="<?= $reqFile ?>" data-code="<?= urlencode($reqCode) ?>"><i class="fas fa-folder"></i></a>
                                                    <?php if ($UserCreate == $globalCurrentUser || CheckAdmin($globalCurrentUser) || CheckManage($globalCurrentUser)){ ?>
                                                        <a class="btn btn-warning btn-sm" href="EditFile?Send_IDNews=<?= urlencode($reqCode); ?>&Send_Title=<?= urlencode($reqTitle); ?>&Send_Category=<?= $Category_id ; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                        <a class="btn btn-danger btn-sm" onclick="deleteAlertFile(<?php echo $reqCode;?>, '<?php echo addslashes(htmlspecialchars_decode($reqTitle, ENT_QUOTES));?>',<?php echo $Category_id;?>)"><i class="fas fa-trash"></i></a>
                                                    <?php }  ?>
                                                <?php endif;  ?>
                                            </td>
                                        </tr>
                                        <?php
                                                // $newnNameImage = $reqCode;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                    <th>วันที่ลง</th>
                                    <th>ประเภท</th>
                                    <th>หัวเรื่อง</th>
                                    <th>เนื่อหาโดยย่อ</th>
                                    <th>เจ้าของ</th>
                                    <th>สถานะ</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Content -->

<?php include("Ma_Footer.php"); ?>
    <!-- sweetalert -->
    <script>
        // ปุ่ม Delete
        function deleteAlert(NewsID, NewsTitle,CategoryId) {
            swal({
                title: "คุณต้องการที่จะลบหรือไม่?",
                text: `${NewsTitle}\nเมื่อกดลบไปแล้วข่าวและกิจกรรมนี้จะไม่สามารถนำข้อมูลกลับมาได้!`,
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
                    window.location.replace(`Pro_DeleteActivities.php?Send_IDNews=${NewsID}&Send_Title=${NewsTitle}&Send_Category=${CategoryId}`);
                } else {
                    // เมื่อกดยกเลิก ไม่ต้องทำอะไร
                }
            })
            .catch((error) => {
                // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
                console.error("Error displaying SweetAlert:", error);
            });
        }
        function deleteAlertFile(NewsID, NewsTitle,CategoryId) {
            swal({
                title: "คุณต้องการที่จะลบหรือไม่?",
                text: `${NewsTitle}\nเมื่อกดลบไปแล้วข่าวและกิจกรรมนี้จะไม่สามารถนำข้อมูลกลับมาได้!`,
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
                    window.location.replace(`Pro_DeleteFileActivities.php?Send_IDNews=${NewsID}&Send_Title=${NewsTitle}&Send_Category=${CategoryId}`);
                } else {
                    // เมื่อกดยกเลิก ไม่ต้องทำอะไร
                }
            })
            .catch((error) => {
                // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
                console.error("Error displaying SweetAlert:", error);
            });
        }
        
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
<?php include("Ma_ScriptDatatable.php"); ?>
<script>
$(document).ready(function() {
    $("#btnShowFile").click(function(event) {
        event.preventDefault(); 
        var code = $(this).data("code");
        var url = $(this).attr("href");
        $.ajax({
            url: "DB_CountPage.php",
            type: "POST",
            data: { Type: 'fileactivities', Code: code },
            dataType: "json",
            success: function(response) {
                console.log("Data sent successfully:", response);
                // window.location.href = url;
                window.open(url, '_blank');
            },
            error: function() {
                console.log("Error occurred");
            }
        });
    });
});
</script>
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
    const sendIsFile = this.getAttribute("data-sendIsFile");
    
    sendDataToPHP(sendStatus, sendID, sendIsFile); // ส่งค่าไปยัง PHP
    });
    function sendDataToPHP(status, id, isFile) {
    // ส่งข้อมูลไปยัง PHP โดยใช้ AJAX
    const xhr = new XMLHttpRequest();
    const url = "DB_ActivitiesHidden.php"; // เปลี่ยนเป็นชื่อไฟล์ PHP ที่คุณต้องการใช้งาน
    const params = "status=" + status + "&id=" + id + "&isFile=" + isFile; // ส่งค่าตัวแปรไปยัง PHP
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
});
</script>
<!-- <script>
    $(document).ready(function() {
        // คือคำสั่งแสดงชื่อบนรูป
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script> -->
<?php include("Ma_Footer_Script.php"); ?>