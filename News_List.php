<?php 
include("DB_Include.php"); 
$_SESSION['PathPage'] = "News_ListAdmin.php";
?>
<?php include("Head_Link.php"); ?>
<!-- Icon Font Stylesheet -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<?php include("Head.php"); ?>
<?php include("Carousel.php"); ?>

    <!-- Content -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-2 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">News & Activities</h6>
                <h1 class="mb-4">ข่าวสารและกิจกรรม</h1>
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
                                        $sql = "SELECT * FROM Activities LEFT JOIN user ON `Activities`.AT_UserCreate = User.US_Username ORDER BY `Activities`.`AT_Date` DESC , `Activities`.`AT_Time` DESC;";
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['AT_Date']; ?></td>
                                            <td><?php echo $row["AT_Title"]; ?></td>
                                            <td class="project_progress">
                                                <?php echo $row["AT_Description"]; ?>
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
                                                <a class="btn btn-primary2 btn-sm" href="News_ShowDetail.php?Send_IDNews=<?= $row["AT_Code"];?>"><i class="fas fa-folder"></i></a>
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
                    // เมื่อกดตกลง ทำการเปลี่ยนหน้า
                    window.location.replace(`Pro_DeleteNews.php?Send_IDNews=${NewsID}`);
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

<?php include("Footer.php"); ?>
<?php include("FirstFooter_Script.php"); ?>
<?php include("Footer_Script.php"); ?>