<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<script>
$(document).ready(function() {

    $("#LoginModal").on("show.bs.modal", function() {
        // กำหนดค่าว่างให้กับ input
        $("#user").val("");
        $("#password").val("");
    });

    $("#modalFormLogin").submit(function(e) {
        e.preventDefault();

        var username = $("#user").val();
        var password = $("#password").val();
        $.ajax({
            url: "DB_Login.php",
            type: "POST",
            data: { user: username, password: password },
            dataType: "json",
            success: function(response) {
                // console.log("Data sent successfully:", response); // แสดงข้อมูลที่ถูกส่งไปในคอนโซล
                if (response.isValidUser) {
                    swal("Success", "Login successful!", "success")
                    .then(() => {
                        window.location.reload();
                    });
                } else {
                    swal("Warning", "Invalid username or password!", "warning");
                }
            },
            error: function() {
                swal("Error", "Error occurred!", "error");
            }
        });
    });
});

function logoutAlert() {
        swal({
            title: "ต้องการที่จะออกจากระบบหรือไม่?",
            text: "เมื่อทำการออกแล้วเราจะพาท่ายไปยังหน้าแรกของการใช้งาน!",
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
                    text: "ตกลง",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
            },
            confirmButtonText: "ตกลง",
            confirmButtonColor: "#1802bf !important",
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "DB_Logout.php",
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "index.php";
                        } else {
                            swal("Error", "Logout failed!", "error");
                        }
                    },
                    error: function() {
                        swal("Error", "Error occurred!", "error");
                    }
                });
            }
        })
        .catch((error) => {
            // เกิดข้อผิดพลาดในกรณีที่ไม่สามารถแสดงกล่อง SweetAlert ได้
            console.error("Error displaying SweetAlert:", error);
        });
    }
</script>
<script>
    <?php if(isset($_SESSION['User']) && !empty($_SESSION['User'])) { ?>
    var sessionTimeout = 30 * 60 * 1000; // 30 นาทีในมิลลิวินาที
    // var sessionTimeout = 10 * 1000; // 10 วิในมิลลิวินาที

    var lastActivity = new Date().getTime();
    var timeout;

    function resetSessionTimeout() {
        clearTimeout(timeout);
        lastActivity = new Date().getTime();
        startSessionTimeout();
    }

    function startSessionTimeout() {
        timeout = setTimeout(function() {
            // หมดเวลาเซสชัน ทำการลบค่าเซสชันและอื่นๆ ตามที่คุณต้องการ
            // ตัวอย่างเช่น redirect ไปยังหน้าหลัก
            window.location.href = "index.php";
            <?php
                // $_SESSION['User'] = '';
                // $_SESSION['StatusTitle'] = "Warning";
                // $_SESSION['StatusMessage'] = "หมดอายุการเข้าใช้งาน";
                // $_SESSION['StatusAlert'] = "warning";
            ?>
        }, sessionTimeout);
    }

    // ตรวจสอบการไม่มีการขยับเม้าทุก 10 วินาที
    setInterval(function() {
        var currentTime = new Date().getTime();
        if (currentTime - lastActivity > sessionTimeout) {
            // หมดเวลาเซสชัน ทำการลบค่าเซสชันและอื่นๆ ตามที่คุณต้องการ
            // ตัวอย่างเช่น redirect ไปยังหน้าหลัก
            location.reload();
        }
    }, 10000);

    // เริ่มต้นตรวจสอบการไม่มีการขยับเม้า
    startSessionTimeout();

    // เมื่อมีการขยับเม้าในหน้าเว็บ เรียกใช้ฟังก์ชัน resetSessionTimeout เพื่อรีเซตเวลา
    document.addEventListener("mousemove", resetSessionTimeout);
    document.addEventListener("keydown", resetSessionTimeout);
    <?php
        }
    ?>
</script>
    <!-- JavaScript Libraries -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <!-- Template sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>