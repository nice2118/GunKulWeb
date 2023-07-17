<?php 
include("DB_Include.php"); 
$_SESSION['PathPage'] = "Ui_ListAdmin.php";
if (isset($_GET['Send_Category']) && $_GET['Send_Category'] !== '') {
    $Category_id = $_GET['Send_Category'];
} else {
    $Category_id = 1;
}
?>

<?php include("Fn_RecursiveCategory.php"); ?>
<?php include("Ma_Head_Link.php"); ?>
<style>
table.dataTable td {
    white-space: normal !important;
    overflow-wrap: break-word !important;
}

</style>
<!-- Icon Font Stylesheet -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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
                <h6 class="small text-primary mb-0 mt-0"><?= $DescriptionEN ?></h6>
                <h2 class="mb-0 mt-0"><?= $DescriptionTH ?></h2>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <div class="d-flex align-items-center">
                    <a class="small fw-medium" href="Ui_Add.php?Send_Category=<?= $Category_id ?>">
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
                                    <th>หัวเรื่อง</th>
                                    <th>เนื่อหาโดยย่อ</th>
                                    <th>เจ้าของ</th>
                                    <th>สถานะ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $SelectFilterCategoryEntityNo = SearchCategory($Category_id);
                                        $sql = "SELECT * FROM Activities LEFT JOIN user ON `Activities`.AT_UserCreate = User.US_Username WHERE (`Activities`.`AT_Entity No.` IN ($SelectFilterCategoryEntityNo)) ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC;";
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['AT_Date']; ?></td>
                                            <td>
                                                <!-- <div class="col-5 text-truncate"> -->
                                                    <?php echo $row["AT_Title"]; ?>
                                                <!-- </div> -->
                                            </td>
                                            <td>
                                                <!-- <div class="col-10 text-truncate"> -->
                                                    <?php echo $row["AT_Description"]; ?>
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
                                                <img class="img-fluid rounded-circle mx-1 mb-1" src="<?php echo "img/testimonial-1.jpg"; ?>" style="width: 40px; height: 40px;">
                                            </td>
                                            <td class="project-actions text-right">
                                                <a class="btn btn-primary2 btn-sm" href="Ui_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>"><i class="fas fa-folder"></i></a>
        
                                                <a class="btn btn-warning btn-sm" href="Ui_Edit.php?Send_IDNews=<?= urlencode($row["AT_Code"]); ?>&Send_Title=<?= urlencode($row["AT_Title"]); ?>&Send_Category=<?= $Category_id ; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger btn-sm" onclick="deleteAlert(<?php echo $row["AT_Code"];?>, '<?php echo $row["AT_Title"];?>',<?php echo $Category_id;?>)"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                                $newnNameImage = $row["AT_Code"];
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                    <th>วันที่ลง</th>
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
<?php include("Ma_Footer_Script.php"); ?>