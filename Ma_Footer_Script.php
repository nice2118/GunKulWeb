<script>
    $(document).ready(function() {
        // $('[data-bs-toggle="tooltip"]').tooltip();
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
<script>
    document.getElementById("modalFormProfile").addEventListener("submit", function (event) {
        var passwordOld = document.getElementById("Profile_PasswordOld").value;
        var password = document.getElementsByName("Profile_Password")[0].value;
        var confirmPassword = document.getElementsByName("Profile_ConfirmPassword")[0].value;

        // เช็คว่าถ้ามีค่าในช่อง Profile_PasswordOld
        if (passwordOld !== "") {
            // ตรวจสอบค่าในช่อง Profile_Password และ Profile_ConfirmPassword
            if (password === "") {
                swal("Error", "กรุณากรอกช่อง New Password!", "error");
                event.preventDefault();
            }
            if (confirmPassword === "") {
                swal("Error", "กรุณากรอกช่อง Confirm Password!", "error");
                event.preventDefault();
            }
            if (password !== confirmPassword) {
                swal("Error", "กรอกช่อง New Password และ Confirm Password ไม่ตรงกัน!", "error");
                event.preventDefault();
            }
            if (password === passwordOld) {
                swal("Error", "ไม่ควรกรอก password เป็นรูปแบบเดิม!", "error");
                event.preventDefault(); 
            }
        }
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
                    swal({
                        title: "Success",
                        text: "Login successful!",
                        icon: "success",
                        timer: 1000, // 1 วินาที
                        buttons: false // ไม่แสดงปุ่ม
                    }).then(() => {
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

    $(document).ready(function() {
        $("#countengravedactivities").click(function(event) {
            event.preventDefault(); 
            var code = $(this).data("code");
            var url = $(this).attr("href");
            $.ajax({
                url: "DB_CountPage.php",
                type: "POST",
                data: { Type: 'engravedactivities', Code: code },
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
});

function logoutAlert(name) {
        swal({
            title: "ออกจากระบบในชื่อ " + name + " หรือไม่?",
            text: "เมื่อทำการออกแล้วเราจะพาท่านไปยังหน้าแรกของการใช้งาน!",
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
                            window.location.href = "Index";
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
    <?php if(isset($globalCurrentUser) && !empty($globalCurrentUser)) { ?>
        let timeout;

        // ฟังก์ชันสำหรับแสดงแจ้งเตือนเมื่อไม่มีการขยับเมาส์เป็นเวลา 30 นาที
        function showMouseInactiveAlert() {
            var data = {
                user: "",
                title: "Warning",
                message: "หมดอายุการเข้าใช้งาน",
                alertType: "warning"
            };
            $.ajax({
                type: "POST",
                url: "DB_ExpiryOFAccess.php",
                data: data,
                success: function(response) {
                    window.location.href = "Index";
                },
                error: function(xhr, status, error) {
                    console.error("Ajax request error:", error);
                }
            });
        }

        // ใช้งาน event listener เพื่อตรวจสอบการขยับเมาส์
        document.addEventListener("mousemove", function() {
            clearTimeout(timeout); // รีเซ็ต timeout ก่อน
            timeout = setTimeout(showMouseInactiveAlert, 1800000); // เริ่มนับเวลาใหม่ 30 นาที 1 นาที = 60000 1 วิ = 1000
        });
    <?php } ?>
</script>
<script>
    document.getElementById('Profile_imageUser').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImageUserProfile = document.getElementById('previewImageUserProfile');
            previewImageUserProfile.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('SignUp_imageUser').addEventListener('change', function (e) {
        var file = e.target.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var previewImageUserSignUp = document.getElementById('previewImageUserSignUp');
            previewImageUserSignUp.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
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