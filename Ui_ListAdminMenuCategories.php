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
<?php include("Fn_Permission.php"); ?>

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
            <h3 class="text-primary mb-0 mt-0"><?= $DescriptionEN ?></h3>
            <h2 class="mb-0 mt-0"><?= $DescriptionTH ?></h2>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="text-start mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-link rounded-pill py-1 px-4 add-image-btn text-start"
                    data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="" data-sendText="" data-sendType="headinggroup" data-sendRelation="<?= $MenuCategory_id ?>" data-sendsort="0">
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
                                        $sqlHeadingGroup = "SELECT * FROM `HeadingGroup` WHERE `HeadingGroup`.`HC_Code` = $MenuCategory_id ORDER BY `HeadingGroup`.`HG_Sort` ASC , `HeadingGroup`.`HG_CreateDate` ASC;";
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
                                                    $sqlHeading = "SELECT * FROM `Heading` WHERE `Heading`.`HG_Code` = '{$rowHeadingGroup["HG_Code"]}' ORDER BY `Heading`.`HD_Sort` ASC , `Heading`.`HD_CreateDate` ASC;";
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
                                                            if ($rowHeadingGroup["HG_UserCreate"] == $_SESSION['User'] || CheckAdmin($_SESSION['User'])){
                                                                if ($rowHeadingGroup["HG_Active"] == 1) {
                                                                    echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton1" data-sendHiddenStatus="0" data-sendHiddenID="' . $rowHeadingGroup['HG_Code'] . '" data-sendHiddenType="headinggroup"><i class="fa fa-eye"></i></a>';
                                                                } else {
                                                                    echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton0" data-sendHiddenStatus="1" data-sendHiddenID="' . $rowHeadingGroup['HG_Code'] . '" data-sendHiddenType="headinggroup"><i class="fa fa-eye-slash"></i></a>';
                                                                }
                                                        ?>
                                                            <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertMenuCategory(<?php echo $rowHeadingGroup["HG_Code"];?>, '<?php echo $rowHeadingGroup["HG_Text"];?>', 'headinggroup')"><i class="fas fa-trash"></i></a>
                                                            <button type="button" class="btn btn-link py-0 px-1 text-end text-warning" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $rowHeadingGroup["HG_Code"] ?>" data-sendText="<?= $rowHeadingGroup["HG_Text"] ?>" data-sendType="headinggroup" data-sendRelation="" data-sendsort="<?= $rowHeadingGroup["HG_Sort"] ?>"><i class="fa fa-pencil-alt"></i></button>
                                                            <button type="button" class="btn btn-link py-0 px-1 text-end text-primary" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="" data-sendText="" data-sendType="heading" data-sendRelation="<?= $rowHeadingGroup["HG_Code"] ?>" data-sendsort="0"><i class="fa fa-plus"></i></button>
                                                        <?php } ?>
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
                                                                        $sqlDetails = "SELECT * FROM `details` WHERE `details`.`HD_Code` = '{$Heading["HD_Code"]}' ORDER BY `details`.`DT_Sort` ASC , `details`.`DT_UserCreate` ASC;";
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
                                                                                    if ($Heading["HD_UserCreate"] == $_SESSION['User'] || CheckAdmin($_SESSION['User'])){
                                                                                        if ($Heading["HD_Active"] == 1) {
                                                                                            echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton1" data-sendHiddenStatus="0" data-sendHiddenID="' . $Heading['HD_Code'] . '" data-sendHiddenType="heading"><i class="fa fa-eye"></i></a>';
                                                                                        } else {
                                                                                            echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton0" data-sendHiddenStatus="1" data-sendHiddenID="' . $Heading['HD_Code'] . '" data-sendHiddenType="heading"><i class="fa fa-eye-slash"></i></a>';
                                                                                        }
                                                                                ?>
                                                                                <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertMenuCategory(<?php echo $Heading["HD_Code"];?>, '<?php echo $Heading["HD_Text"];?>', 'heading')"><i class="fas fa-trash"></i></a>
                                                                                <button type="button" class="btn btn-link py-0 px-1 text-end text-warning" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $Heading["HD_Code"] ?>" data-sendText="<?= $Heading["HD_Text"] ?>" data-sendType="heading" data-sendRelation="" data-sendsort="<?= $Heading["HD_Sort"] ?>"><i class="fa fa-pencil-alt"></i></button>
                                                                                <button type="button" class="btn btn-link py-0 px-1 text-end text-primary" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="" data-sendText="" data-sendType="details" data-sendRelation="<?= $Heading["HD_Code"] ?>" data-sendsort="0"><i class="fa fa-plus"></i></button>
                                                                                <?php } ?>
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
                                                                                                    if ($Details["DT_UserCreate"] == $_SESSION['User'] || CheckAdmin($_SESSION['User'])){
                                                                                                        if ($Details["DT_Active"] == 1) {
                                                                                                            echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton1" data-sendHiddenStatus="0" data-sendHiddenID="' . $Details['DT_Code'] . '" data-sendHiddenType="details"><i class="fa fa-eye"></i></a>';
                                                                                                        } else {
                                                                                                            echo '<a class="btn btn-link py-0 px-1 text-end text-secondary toggleButton" id="toggleButton0" data-sendHiddenStatus="1" data-sendHiddenID="' . $Details['DT_Code'] . '" data-sendHiddenType="details"><i class="fa fa-eye-slash"></i></a>';
                                                                                                        }
                                                                                                ?>
                                                                                                    <a class="btn btn-link py-1 px-2 text-end" onclick="deleteAlertMenuCategory(<?php echo $Details["DT_Code"];?>, '<?php echo $Details["DT_Text"];?>', 'details')"><i class="fas fa-trash"></i></a>
                                                                                                    <button type="button" class="btn btn-link py-0 px-1 text-end text-warning" data-bs-toggle="modal" data-bs-target="#AddEditHeading" data-sendCode="<?= $Details["DT_Code"] ?>" data-sendText="<?= $Details["DT_Text"] ?>" data-sendType="details" data-sendRelation="<?= $Heading["HD_Code"] ?>" data-sendsort="<?= $Details["DT_Sort"] ?>"><i class="fa fa-pencil-alt"></i></button>
                                                                                                <?php } ?>
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
                <form id="modalFormMenuCategory2" action="Pro_Add&EditMenuCategory.php" method="post" enctype="multipart/form-data">
                    <div class="row g-2 my-2">
                        <div class="col-12 col-sm-12">
                            <input type="hidden" id="Send_Code" name="Send_Code">
                            <input type="hidden" id="Send_descriptionth" name="Send_descriptionth" value="">
                            <input type="hidden" id="Send_descriptionen" name="Send_descriptionen" value="">
                            <input type="hidden" id="Send_MenuCategoryType" name="Send_MenuCategoryType">
                            <input type="hidden" id="Send_Relation" name="Send_Relation">
                            <h6 class="text-primary">ชื่อ</h6>
                            <textarea id="Send_Text" name="Send_Text" class="form-control border-1" style="height: 120px;" rows="5" placeholder="ชื่อหัวข้อ" required></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-end my-2">
                        <div class="col-2 col-sm2">
                            <h6 class="text-primary">ลำดับ</h6>
                            <input type="number" class="form-control border-1" id="Send_Sort" name="Send_Sort" min="0" max="99">                        
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
function deleteAlertMenuCategory(SendID, SendsTitle,SendType) {
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
<?php // include("Ma_ScriptDatatable.php"); ?>
<script src="js/jquery.min.js"></script>
<script src="js/adminlte.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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
    // const sendStatus = this.getAttribute("data-sendHiddenStatus");
    const sendType = this.getAttribute("data-sendHiddenType");
    const sendID = this.getAttribute("data-sendHiddenID");
    sendDataToPHP(sendStatus, sendType, sendID); // ส่งค่าไปยัง PHP
  });
});

function sendDataToPHP(status, type, id) {
  // ส่งข้อมูลไปยัง PHP โดยใช้ AJAX
  const xhr = new XMLHttpRequest();
  const url = "DB_MenuCategoryHidden.php"; // เปลี่ยนเป็นชื่อไฟล์ PHP ที่คุณต้องการใช้งาน
  const params = "status=" + status + "&type=" + type + "&id=" + id; // ส่งค่าตัวแปรไปยัง PHP
  console.log(params);
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // ทำสิ่งที่คุณต้องการหลังจากที่ส่งข้อมูลเสร็จสิ้น (หากต้องการ)
    //   console.log(xhr.responseText); // ตัวอย่างการแสดงผล response ที่ได้จาก PHP
    }
  };
  xhr.send(params);
}
</script>
    <!-- Edit -->
<script>
    // เมื่อ Modal AddEditHeading ถูกเปิดขึ้นมา
    $('#AddEditHeading').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const sendcode = button.data('sendcode');
        const sendtext = button.data('sendtext');
        const sendtype = button.data('sendtype');
        const sendrelation = button.data('sendrelation');
        const sendSort = button.data('sendsort');

        // console.log(sendcode);
        console.log(sendtext);
        // console.log(sendtype);
        // console.log(sendrelation);

        // กำหนดค่าให้กับช่อง input ใน Modal
        document.getElementById("Send_MenuCategoryType").value = sendtype;
        document.getElementById("Send_Code").value = sendcode;
        document.getElementById("Send_Relation").value = sendrelation;
        if (sendtext === undefined) {
            document.getElementById("Send_Text").value = '';
        } else {
            document.getElementById("Send_Text").value = sendtext;
        }
        document.getElementById("Send_Sort").value = sendSort;

        if (sendtype === 'headinggroup') {
            $('#Send_Text').summernote('destroy');
            if (!sendtext) {
            document.getElementById("Send_Text").value = '';
            } else {
                document.getElementById("Send_Text").value = sendtext;
            }
        } else if (sendtype === 'heading' || sendtype === 'details') {
            $('#Send_Text').summernote('destroy');
            $('#Send_Text').summernote({
                placeholder: 'กรุณากรอกข้อมูลที่จะแสดง',
                tabsize: 2,
                height: 200,
                toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                onInit: function() {
                    if (!sendtext) {
                        $('#Send_Text').summernote('code', '');
                    } else {
                        $('#Send_Text').summernote('code', sendtext);
                    }
                }
            }
            });
        }
    });
</script>
<?php include("Ma_Footer_Script.php"); ?>
