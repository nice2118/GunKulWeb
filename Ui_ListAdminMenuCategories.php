<?php 
include("DB_Include.php");

$MenuCategory_id = isset($_GET['Send_MenuCategory']) && $_GET['Send_MenuCategory'] !== '' ? $_GET['Send_MenuCategory'] : 1;
$_SESSION['PathPage'] = "Ui_ListAdminMenuCategories.php?Send_MenuCategory=".$MenuCategory_id;

include("Ma_Head_Link.php");
?>
			 
<!-- Icon Font Stylesheet -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
thead,
tbody,
tfoot,
tr,
td,
th {
    border-style: none;
}
</style>

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
                    data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-hgCode="0" data-hgText="">
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
                            <table class="table table-hover2">
                                <tbody>
                                <?php
                                        $sqlHeadingGroup = "SELECT * FROM `HeadingGroup` WHERE `HeadingGroup`.`HC_Code` = $MenuCategory_id;";
                                        $resultHeadingGroup = $conn->query($sqlHeadingGroup);
                                        if ($resultHeadingGroup->num_rows > 0) {
                                            while ($rowHeadingGroup = $resultHeadingGroup->fetch_assoc()) {
                                                $DataHeading = array();
                                                $DataDetails = array();
                                    ?>
                                            <tr data-widget="expandable-table" aria-expanded="true">
                                                <td>
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                <?php
                                                    $sqlHeading = "SELECT * FROM `Heading` WHERE `Heading`.`HG_Code` = '{$rowHeadingGroup["HG_Code"]}';";
                                                    $resultHeading = $conn->query($sqlHeading);
                                                    if ($resultHeading->num_rows > 0) {  
                                                ?>
                                                            <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                <?php
                                                        while ($rowHeading = $resultHeading->fetch_assoc()) {
                                                            $DataHeading[] = $rowHeading;
                                                        }
                                                    }
                                                ?>
                                                        <?= $rowHeadingGroup["HG_Text"] ?></h5>
                                                        <div class="card-tools">
                                                            <?php
                                                                if ($rowHeadingGroup["HG_Active"] == 1) {
                                                                    echo '<a class="btn btn-link py-0 px-1 text-end text-secondary"><i class="fa fa-eye"></i></a>';
                                                                } else {
                                                                    echo '<a class="btn btn-link py-0 px-1 text-end text-secondary"><i class="fa fa-eye-slash"></i></a>';
                                                                }
                                                            ?>
                                                            <a class="btn btn-link py-0 px-1 text-end" ><i class="fa fa-trash"></i></a>
                                                            <button type="button" class="btn btn-link py-0 px-1 text-end text-warning" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $rowHeadingGroup["HG_Code"] ?>" data-sendText="<?= $rowHeadingGroup["HG_Text"] ?>" data-sendType="HeadingGroup"><i class="fa fa-pencil-alt"></i></button>
                                                            <button type="button" class="btn btn-link py-0 px-1 text-end text-primary" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $Heading["HD_Code"] ?>" data-sendText="<?= $Heading["HD_Text"] ?>" data-sendType="Heading"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php 
                                                if (count($DataHeading) > 0) {
                                    ?>
                                            <tr class="expandable-body">
                                                <td>
                                                    <div class="p-0">
                                                        <table class="table table-hover2">
                                                            <tbody>
                                                                <?php
                                                                    foreach ($DataHeading as $Heading) { 
                                                                        $DataDetails = array();
                                                                        $sqlDetails = "SELECT * FROM `details` WHERE `details`.`HD_Code` = '{$Heading["HD_Code"]}';";
                                                                        $resultDetails = $conn->query($sqlDetails);
                                                                        if ($resultDetails->num_rows > 0) {
                                                                            while ($rowDetails = $resultDetails->fetch_assoc()) {
                                                                                $DataDetails[] = $rowDetails;
                                                                            }
                                                                        }
                                                                ?>
                                                                <tr data-widget="expandable-table" aria-expanded="false">
                                                                    <td>
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">
                                                                            <?php if (count($DataDetails) > 0) { echo '<i class="expandable-table-caret fas fa-caret-right fa-fw"></i>'; }?>
                                                                            <?= $Heading["HD_Text"] ?></h6>
                                                                            <div class="card-tools">
                                                                                <?php
                                                                                    if ($Heading["HD_Active"] == 1) {
                                                                                        echo '<a class="btn btn-link py-0 px-1 text-end text-secondary"><i class="fa fa-eye"></i></a>';
                                                                                    } else {
                                                                                        echo '<a class="btn btn-link py-0 px-1 text-end text-secondary"><i class="fa fa-eye-slash"></i></a>';
                                                                                    }
                                                                                ?>
                                                                                <a class="btn btn-link py-0 px-1 text-end" ><i class="fa fa-trash"></i></a>
                                                                                <button type="button" class="btn btn-link py-0 px-1 text-end text-warning" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $Heading["HD_Code"] ?>" data-sendText="<?= $Heading["HD_Text"] ?>" data-sendType="Heading"><i class="fa fa-pencil-alt"></i></button>
                                                                                <button type="button" class="btn btn-link py-0 px-1 text-end text-primary" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $Details["DT_Code"] ?>" data-sendText="<?= $Details["DT_Text"] ?>" data-sendType="details"><i class="fa fa-plus"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                                    
                                                                        if (count($DataDetails) > 0) { 
                                                                ?>
                                                                <tr class="expandable-body">
                                                                    <td>
                                                                        <div class="p-0">
                                                                            <table class="table table-hover2">
                                                                                <tbody>
                                                                                <?php foreach ($DataDetails as $Details) { ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="card-header">    
                                                                                                <?= $Details["DT_Text"] ?>
                                                                                                <div class="card-tools">
                                                                                                    <?php
                                                                                                        if ($Details["DT_Active"] == 1) {
                                                                                                            echo '<a class="btn btn-link py-0 px-1 text-end text-secondary"><i class="fa fa-eye"></i></a>';
                                                                                                        } else {
                                                                                                            echo '<a class="btn btn-link py-0 px-1 text-end text-secondary"><i class="fa fa-eye-slash"></i></a>';
                                                                                                        }
                                                                                                    ?>
                                                                                                    <a class="btn btn-link py-0 px-1 text-end" ><i class="fa fa-trash"></i></a>
                                                                                                    <button type="button" class="btn btn-link py-0 px-1 text-end text-warning" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $Details["DT_Code"] ?>" data-sendText="<?= $Details["DT_Text"] ?>" data-sendType="details"><i class="fa fa-pencil-alt"></i></button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php 
                                                                        }
                                                                    } 
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </tbody>
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

<!-- Modal HeadingGroup-->
<div class="modal fade" id="AddEditHeading" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="AddEditHeadingLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddEditHeadingLabel">Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="#" method="post" enctype="multipart/form-data">
                    <div class="row g-2 my-2">
                        <div class="col-112 col-sm-112">
                            <input type="hidden" id="Type" name="Type">
                            <input type="hidden" id="Code" name="Code">
                            <h6 class="text-primary">ชื่อ</h6>
                            <textarea id="Text" name="Text" class="form-control border-1" style="height: 120px;" rows="5" placeholder="ชื่อหัวข้อ" required></textarea>
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
<!-- sweetalert -->
<script>
// ปุ่ม Delete
function deleteAlert(SendID, SendsTitle,SendType) {
    swal({
            title: "คุณต้องการที่จะลบหรือไม่?",
            text: `${SendsTitle}\nเมื่อกดลบไปแล้วจะไม่สามารถนำข้อมูลกลับมาได้!`,
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
                window.location.replace(`Pro_DeleteMenuCategory.php?Send_ID=${SendID}&Send_Text=${SendsTitle}&Send_Type=${SendType}` );
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
<script src="js/jquery.min.js"></script>
<script src="js/adminlte.min.js"></script>
    <!-- Edit -->
<script>
    // เมื่อ Modal AddEditHeading ถูกเปิดขึ้นมา
    $('#AddEditHeading').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const sendType = button.data('sendType');
        const sendcode = button.data('sendcode');
        const sendtext = button.data('sendtext');

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("Type").value = sendType;
        document.getElementById("Code").value = sendcode;
        document.getElementById("Text").value = sendtext;
    });
</script>
<?php include("Ma_Footer_Script.php"); ?>