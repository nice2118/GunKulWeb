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
                        $IsFile = $row["CG_IsFile"];
                    }
                ?>
                <h3 class="text-primary mb-0 mt-0"><?= $DescriptionEN ?></h3>
                <h2 class="mb-0 mt-0"><?= $DescriptionTH ?></h2>
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
                                    <th>วันที่ลง</th>
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
                                            $sql = "SELECT * FROM Activities LEFT JOIN user ON `Activities`.AT_UserCreate = User.US_Username WHERE (`Activities`.`AT_Entity No.` IN ($SelectFilterCategoryEntityNo)) ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC;";
                                        elseif ($IsFile == 1):
                                            $sql = "SELECT * FROM FileActivities LEFT JOIN user ON `FileActivities`.FA_UserCreate = User.US_Username WHERE (`FileActivities`.`FA_Entity No.` IN ($SelectFilterCategoryEntityNo)) ORDER BY `FileActivities`.`FA_Date` DESC , `FileActivities`.`FA_Time` DESC;";
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
                                                if ($IsFile == 0){
                                                    $reqCode = $row['AT_Code'];
                                                    $reqDate = $row['AT_Date'];
                                                    $reqTitle = $row['AT_Title'];
                                                    $reqDescription = $row['AT_Description'];
                                                    $fullName = $row['US_Fname'].' '.$row['US_Lname'];
                                                } elseif ($IsFile == 1) {
                                                    $reqCode = $row['FA_Code'];
                                                    $reqDate = $row['FA_Date'];
                                                    $reqTitle = $row['FA_Title'];
                                                    $reqDescription = $row['FA_Description'];
                                                    $fullName = $row['US_Fname'].' '.$row['US_Lname'];
                                                    
                                                    $sqlSetup = "SELECT * FROM Setup";
                                                    $resultSetup = $conn->query($sqlSetup);
                                                    if ($resultSetup->num_rows > 0) {
                                                        $rowSetup = $resultSetup->fetch_assoc();
                                                        $reqFile = $rowSetup['SU_PathDefaultFile'].$row['FA_File'];
                                                    }
                                                }
                                        ?>
                                        <tr>
                                            <td><?php echo $reqDate; ?></td>
                                            <td><?php echo $reqTitle; ?></td>
                                            <td class="project_progress">
                                                <?php echo $reqDescription; ?>
                                                <!-- <div class="progress progress-sm">
                                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%">
                                                    </div>
                                                </div>
                                                <small>
                                                    35% Complete
                                                </small> -->
                                            </td>
                                            <td>
                                                <img class="img-fluid rounded-circle mx-1 mb-1" src="Default/DefaultUser/0.png" alt="User Image" style="width: 40px; height: 40px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $fullName;?>">
                                            </td>
                                            <td class="project-actions text-right">
                                                <?php if ($IsFile == 0): ?>
                                                    <a class="btn btn-primary2 btn-sm" href="Ui_ShowDetail.php?Send_IDNews=<?= $reqCode?>"><i class="fas fa-folder"></i></a>
                                                <?php elseif ($IsFile == 1): ?>
                                                    <a class="btn btn-primary2 btn-sm" href="<?= $reqFile ?>" data-code="<?= urlencode($reqCode) ?>"><i class="fas fa-folder"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                                // $newnNameImage = $row["AT_Code"];
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

<?php include("Ma_Footer.php"); ?>
<?php include("Ma_FirstFooter_Script.php"); ?>
<?php include("Ma_ScriptDatatable.php"); ?>
<script>
$(document).ready(function() {
    $(".btn-primary2").click(function(event) {
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
                window.location.href = url;
            },
            error: function() {
                console.log("Error occurred");
            }
        });
    });
});
</script>
<?php include("Ma_Footer_Script.php"); ?>