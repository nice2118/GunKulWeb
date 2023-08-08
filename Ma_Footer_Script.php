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
                console.log("Data sent successfully:", response); // แสดงข้อมูลที่ถูกส่งไปในคอนโซล
                if (response.isValidUser) {
                    swal("Success", "Login successful!", "success");
                    window.location.reload(); // รีเฟรชหน้าปัจจุบัน
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