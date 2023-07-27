<?php 
include("DB_Include.php"); 
$_SESSION['PathPage'] = "Ui_ListAdminMenuCategory.php";
if (isset($_GET['Send_MenuCategory']) && $_GET['Send_MenuCategory'] !== '') {
    $MenuCategory_id = $_GET['Send_MenuCategory'];
} else {
    $MenuCategory_id = 1;
}
?>

<?php include("Ma_Head_Link.php"); ?>
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
                    $sql = "SELECT * FROM `HeadingCategories` WHERE `HeadingCategories`.`HC_Code` = $MenuCategory_id;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $DescriptionTH = $row["HC_DescriptionTH"];
                        $DescriptionEN = $row["HC_DescriptionEN"];
                    }
                ?>
            <h6 class="small text-primary mb-0 mt-0"><?= $DescriptionEN ?></h6>
            <h2 class="mb-0 mt-0"><?= $DescriptionTH ?></h2>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-link rounded-pill py-1 px-4 add-image-btn text-start"
                    data-bs-toggle="modal" data-bs-target="#AddHeadingGroup">
                    <div class="d-flex align-items-center">
                        <div class="btn-lg-square bg-primary rounded-circle">
                            <i class="fa fa-plus text-white"></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="small text-primary mb-0 mt-0">Add <?= $DescriptionEN ?></h6>
                            <h5 class="mb-0 mt-0">เพิ่ม<?= $DescriptionTH ?></h5>
                        </div>
                    </div>
                </button>
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
                            <table id="example2" class="table table-striped projects">
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
                                    <tr data-widget="expandable-table" aria-expanded="false">
                                        <td>1111</td>
                                        <td>2222</td>
                                        <td>3333</td>
                                        <td>4444</td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-warning btn-sm" href=""><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <a class="btn btn-danger btn-sm" href=""><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
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

<!-- Modal Category-->
<div class="modal fade" id="AddHeadingGroup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="Pro_Add&EditCategory.php" method="post" enctype="multipart/form-data">
                    <div class="row g-2 my-2">
                        <div class="col-3 col-sm-2">
                            <h6 class="text-primary">รหัส</h6>
                            <input type="Text" id="CG_EntityNo" name="CG_EntityNo" class="form-control border-1"
                                placeholder="0" readonly>
                        </div>
                        <div class="col-5 col-sm-5">
                            <h6 class="text-primary">ชื่อ</h6>
                            <input type="Text" id="CG_Name" name="CG_Name" class="form-control border-1"
                                placeholder="ชื่อหัวข้อ" required>
                        </div>
                        <div class="col-6 col-sm-6">
                            <h6 class="text-primary">ชื่อภาษาไทย</h6>
                            <input type="Text" id="CG_DescriptionTH" name="CG_DescriptionTH"
                                class="form-control border-1" placeholder="ชื่อภาษาไทย" required>
                        </div>
                        <div class="col-6 col-sm-6">
                            <h6 class="text-primary">ชื่อภาษาอังกฤษ</h6>
                            <input type="Text" id="CG_DescriptionEN" name="CG_DescriptionEN"
                                class="form-control border-1" placeholder="ชื่อภาษาอังกฤษ" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <!-- <button type="button" class="btn btn-primary" onclick="submitModalForm()">บันทึก</button> -->
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include("Ma_Footer.php"); ?>
<!-- sweetalert -->
<script>
// ปุ่ม Delete
function deleteAlert(NewsID, NewsTitle) {
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
                window.location.replace(
                    `Pro_DeleteActivities.php?Send_IDNews=${NewsID}&Send_Title=${NewsTitle}&Send_Category=${CategoryId}`
                );
            }
        })
        .catch((error) => {
            console.error("Error displaying SweetAlert:", error);
        });
}

// ตรวจสอบว่ามีข้อความใน Session หรือไม่
<?php if (isset($_SESSION['StatusMessage'])) : ?>
// แสดงข้อความแจ้งเตือนเมื่อโหลดหน้า
window.onload = function() {
    swal("<?php echo $_SESSION['StatusTitle']; ?>", "<?php echo $_SESSION['StatusMessage']; ?>",
        "<?php echo $_SESSION['StatusAlert']; ?>");
    <?php unset($_SESSION['StatusTitle'], $_SESSION['StatusMessage'], $_SESSION['StatusAlert']); ?> // ลบค่าใน Session เพื่อไม่ให้แสดงซ้ำ
};
<?php endif; ?>
</script>
<?php include("Ma_FirstFooter_Script.php"); ?>
<?php include("Ma_ScriptDatatable.php"); ?>
<script>
// DataTable ของ example2
new DataTable('#example2', {
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/th.json"
    }
});
</script>
<script src="js/jquery.min.js"></script>
<script src="js/adminlte.min.js"></script>
<?php include("Ma_Footer_Script.php"); ?>