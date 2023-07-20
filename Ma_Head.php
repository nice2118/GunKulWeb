</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <!-- <div class="h-100 d-inline-flex align-items-center me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>123 Street, New York, USA</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
                </div> -->
            </div>
            <div class="col-lg-5 px-5 text-end">
                <!-- <div class="h-100 d-inline-flex align-items-center me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+012 345 6789</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center mx-n2">
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-square btn-link rounded-0" href=""><i class="fab fa-instagram"></i></a>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <!-- <nav id="main_nav" class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0"> -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="Index.php" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
            <!-- <h2 class="m-0 text-primary">GUNKUL</h2> -->
            <img class="img-fluid" src="img/GKE.png" style="width:200px;" />
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">เมนูหลัก</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="https://www.gunkul.com/th/about-us/nature-of-business" class="dropdown-item" target="_blank">ข้อมูลบริษัท</a>
                        <a href="https://www.gunkul.com/storage/about-us/20220701-gunkul-org-th.jpg" class="dropdown-item" target="_blank">โครงสร้างองค์กร</a>
                        <a href="https://www.gunkul.com/th/corporate-governance/policy-and-procedures" class="dropdown-item" target="_blank">นโยบายยริษัท</a>
                        <a href="https://www.gunkul.com/th/about-us/management/board-of-directors" class="dropdown-item" target="_blank">โครงสร้างการจัดการ</a>
                        <a href="https://www.gunkul.com/th/investor-relations/ir-home" class="dropdown-item" target="_blank">นักลงทุนสัมพันธ์</a>
                        <nav>
                            <a href="" class="dropdown-item">รายการ&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu multi-menu">
                            <?php
                                $sql = "SELECT * FROM `Category` WHERE `Category`.`CG_Entity Relation No.` = 0;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                                <li><a href="Ui_ShowPage.php?Send_Category=<?= $row["CG_Entity No."] ?>&Multiplier=1&Search=" class="dropdown-item"><?= $row["CG_DescriptionTH"] ?></a></li>
                            <?php
                                    }
                                }
                            ?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">ข่าวสารและประชาสัมพันธ์</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="#" class="dropdown-item">ประกาศ ***</a>
                        <a href="#" class="dropdown-item">ข่าวและกิจกรรมบริษัท ***</a>
                        <a href="#" class="dropdown-item">กระทู้พูดคุย ชวนแชร์ ***</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">มุม HR</a>
                    <div class="dropdown-menu bg-light m-0">
                        <nav>
                            <a href="" class="dropdown-item">แผนกสรรหาว่าจ้างและฝึกอบรม&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu multi-menu">
                                <li><a href="#" class="dropdown-item">GKA Newcomer ***</a></li>
                                <li><a href="https://www.gunkul.com/th/careers/available-positions" class="dropdown-item">ตำแหน่งงานว่างภายใน</a></li>
                            </ul>
                        </nav>
                        <nav>
                            <a href="" class="dropdown-item">แผนกเงินเดือนและสวัสดิการ&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu multi-menu">
                            <li><a href="#" class="dropdown-item">สวัสดิการพนักงาน ***</a></li>
                            </ul>
                        </nav>
                        <nav>
                            <a href="" class="dropdown-item">วันหยุดประจำปี&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu multi-menu">
                                <li><a href="PDF\Holiday\2566\GKE_5_HQ.pdf" target="_blank" class="dropdown-item">สำนักงานใหญ่ GKE</a></li>
                                <li><a href="PDF\Holiday\2566\GKE_6_Site.pdf" target="_blank" class="dropdown-item">ไซต์งานก่อสร้าง และ O&M GKE</a></li>
                                <li><a href="PDF\Holiday\2566\GKAP.pdf" target="_blank" class="dropdown-item">โรงงาน GKA & GKP</a></li>
                                <li><a href="PDF\Holiday\2566\GPD_5_HQ.pdf" target="_blank" class="dropdown-item">สำนักงานใหญ่ GPD</a></li>
                                <li><a href="PDF\Holiday\2566\GPD_6_SITE.pdf" target="_blank" class="dropdown-item">ไซต์งานก่อสร้าง GPD</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">แหล่งข้อมูล</a>
                    <div class="dropdown-menu bg-light m-0">
                        <nav>
                            <a href="" class="dropdown-item">ความรู้ทั่วไป&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu multi-menu">
                                <li><a href="#" class="dropdown-item" target="_blank">ERP Dynamics 365 F&O ***</a></li>
                                <li><a href="#" class="dropdown-item" target="_blank">ERP AX2012 R2, R3 ***</a></li>
                                <li><a href="https://youtu.be/Ok9enjSDvUU" class="dropdown-item" target="_blank">e-Document (e-Doc)</a></li>
                            </ul>
                        </nav>
                        </li>
                        <a href="#" class="dropdown-item" target="_blank">คู่มือการปฏิบัติงาน ***</a>
                        <a href="#" class="dropdown-item" target="_blank">แบบฟอร์ม ***</a>
                        <a href="#" class="dropdown-item" target="_blank">e-learning ***</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">แผนที่บริษัท</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="https://www.gunkul.com/th/contact-us/head-office" target="_blank" class="dropdown-item">GUNKUL</a>
                        <a href="#" target="_blank" class="dropdown-item">GKA & GKP ***</a>
                        <a href="#" target="_blank" class="dropdown-item">GPD ***</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">เบอร์ติดต่อภายใน</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="PDF\TelephoneNumber\เบอร์โทรศัพท์ภายใน - GKE-090623.pdf" target="_blank" class="dropdown-item">สำนักงานใหญ่ GKE</a>
                        <a href="PDF\TelephoneNumber\เบอร์โทรศัพท์ภายใน - GKAP-190623.pdf" target="_blank" class="dropdown-item">โรงงาน GKA & GKP</a>
                        <a href="PDF\TelephoneNumber\เบอร์โทรศัพท์ภายใน - GPD-090623.pdf" target="_blank" class="dropdown-item">สำนักงานใหญ่ GPD</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">เว็บภายใน</a>
                    <div class="dropdown-menu bg-light m-0">
                        <nav>
                            <a href="" class="dropdown-item">ระบบจริง&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu submenu-left">
                                <li><a href="https://hrm.gunkul.net/LoginERS/login.aspx" target="_blank" class="dropdown-item"><i
                                class="fa fa-heartbeat text-primary"></i> ระบบลาและเงินเดือน</a></li>
                                <li><a href="http://meetingroom.gunkul.com/login" target="_blank" class="dropdown-item"><i
                                class="fa fa-users text-primary"></i> จองห้องประชุม</a></li>
                                <li><a href="https://edoc.gunkul.com/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ e-Doc GKE</a></li>
                                <li><a href="https://edocgka.gunkul.com/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ e-Doc GKA, P</a></li>
                                <li><a href="https://edoc.gpdpublic.com/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ e-Doc GPD</a></li>
                                <li><a href="https://edocjv.gunkul.com/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ e-Doc JV</a></li>
                            </ul>
                        </nav>
                        <nav>
                            <a href="" class="dropdown-item">ระบบเทส&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu submenu-left">
                                <li><a href="https://edocdev.gunkul.com/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc GKE</a></li>
                                <li><a href="https://gkadev.gunkul.com/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc GKA, P</a></li>
                                <li><a href="https://10.10.9.183:8443/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc GPD</a></li>
                                <li><a href="https://http://10.10.9.166:8080/share/page" target="_blank" class="dropdown-item"><i
                                class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc JV</a></li>
                            </ul>
                        </nav>
                        <nav>
                            <a href="" class="dropdown-item">จัดการ&nbsp;&nbsp;<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu-submenu submenu submenu-left">
                            <?php
                                $sql = "SELECT * FROM `Category` WHERE `Category`.`CG_Entity Relation No.` = 0;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                                <li><a href="Ui_ListAdmin.php?Send_Category=<?= $row["CG_Entity No."] ?>" class="dropdown-item"><?= $row["CG_DescriptionTH"] ?></a></li>
                            <?php
                                    }
                                }
                            ?>
                            </ul>
                        </nav>
                        <a href="Ui_AdminSetup.php" class="dropdown-item">Setup</a>
                        <a href="Ui_Activity.php" class="dropdown-item">Activity</a>
                    </div>
                </div>
            </div>
            <a href="" class="btn btn-white rounded-0 py-4 px-lg-3 d-none d-lg-block"><i class="fa fa-archive ms-auto fs-5"></i></a>
        </div>


<!-- <div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav ms-auto p-4 p-lg-0"> -->
        <!-- <ul>
            <li>
                <a href="" class="nav-link dropdown-toggle">เมนูหลัก</a>
                <ul>
                    <li><a href="https://www.gunkul.com/th/about-us/nature-of-business" target="_blank">ข้อมูลบริษัท</a></li>
                    <li><a href="https://www.gunkul.com/storage/about-us/20220701-gunkul-org-th.jpg" target="_blank">โครงสร้างองค์กร</a></li>
                    <li><a href="https://www.gunkul.com/th/corporate-governance/policy-and-procedures" target="_blank">นโยบายยริษัท</a></li>
                    <li><a href="https://www.gunkul.com/th/about-us/management/board-of-directors" target="_blank">โครงสร้างการจัดการ</a></li>
                    <li><a href="https://www.gunkul.com/th/investor-relations/ir-home" target="_blank">นักลงทุนสัมพันธ์</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">ข่าวสารและประชาสัมพันธ์</a>
                <ul>
                    <li><a href="#">ประกาศ</a></li>
                    <li><a href="#">ข่าวและกิจกรรมบริษัท</a></li>
                    <li><a href="#">กระทู้พูดคุย ชวนแชร์</a></li>
                    <li></li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">ข่าวสารและประชาสัมพันธ์</a>
                <ul>
                    <li><a href="#">ประกาศ</a></li>
                    <li><a href="#">ข่าวและกิจกรรมบริษัท</a></li>
                    <li><a href="#">กระทู้พูดคุย ชวนแชร์</a></li>
                    <li></li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">มุม HR</a>
                <ul>
                    <li>
                        <a href="" class="nav-link dropdown-toggleLine">แผนกสรรหาว่าจ้างและฝึกอบรม</a>
                        <ul>
                            <li><a href="#">GKA Newcomer</a></li>
                            <li><a href="#">ตำแหน่งงานว่างภายใน</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="" class="nav-link dropdown-toggleLine">แผนกเงินเดือนและสวัสดิการ</a>
                        <ul>
                            <li><a href="#">สวัสดิการพนักงาน</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="" class="nav-link dropdown-toggleLine">วันหยุดประจำปี</a>
                        <ul>
                            <li><a href="PDF\Holiday\2566\GKE_5_HQ.pdf" target="_blank">สำนักงานใหญ่ GKE</a></li>
                            <li><a href="PDF\Holiday\2566\GKE_6_Site.pdf" target="_blank">ไซต์งานก่อสร้าง และ O&M GKE</a></li>
                            <li><a href="PDF\Holiday\2566\GKAP.pdf" target="_blank">โรงงาน GKA & GKP</a</li>
                            <li><a href="PDF\Holiday\2566\GPD_5_HQ.pdf" target="_blank">สำนักงานใหญ่ GPD</a></li>
                            <li><a href="PDF\Holiday\2566\GPD_6_SITE.pdf" target="_blank">ไซต์งานก่อสร้าง GPD</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">แหล่งข้อมูล</a>
                <ul>
                    <li>
                        <a href="" class="nav-link dropdown-toggleLine">ความรู้ทั่วไป</a>
                        <ul>
                            <li><a href="#" target="_blank">ERP Dynamics 365 F&O</a></li>
                            <li><a href="#" target="_blank">ERP AX2012 R2, R3</a></li>
                            <li><a href="https://youtu.be/Ok9enjSDvUU" target="_blank">e-Document (e-Doc)</a></li>
                        </ul>
                    </li>
                    <li><a href="#" target="_blank">คู่มือการปฏิบัติงาน</a></li>
                    <li><a href="#" target="_blank">แบบฟอร์ม</a></li>
                    <li><a href="#" target="_blank">e-learning</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">แผนที่บริษัท</a>
                <ul>
                    <li><a href="#" target="_blank">คู่มือการปฏิบัติงาน</a></li>
                    <li><a href="#" target="_blank">แบบฟอร์ม</a></li>
                    <li><a href="#" target="_blank">e-learning</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">แผนที่บริษัท</a>
                <ul>
                    <li><a href="https://www.gunkul.com/th/contact-us/head-office" target="_blank">GUNKUL</a></li>
                    <li><a href="#" target="_blank">GKA & GKP</a></li>
                    <li><a href="#" target="_blank">GPD</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">เบอร์ติดต่อภายใน</a>
                <ul>
                    <li><a href="PDF\TelephoneNumber\เบอร์โทรศัพท์ภายใน - GKE-090623.pdf" target="_blank">สำนักงานใหญ่ GKE</a></li>
                    <li><a href="PDF\TelephoneNumber\เบอร์โทรศัพท์ภายใน - GKAP-190623.pdf" target="_blank">โรงงาน GKA & GKP</a></li>
                    <li><a href="PDF\TelephoneNumber\เบอร์โทรศัพท์ภายใน - GPD-090623.pdf" target="_blank">สำนักงานใหญ่ GPD</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="nav-link dropdown-toggle">เบอร์ติดต่อภายใน</a>
                <ul>
                    <li><a href="https://hrm.gunkul.net/LoginERS/login.aspx" target="_blank"><i class="fa fa-heartbeat text-primary"></i> ระบบลาและเงินเดือน</a></li>
                    <li><a href="http://meetingroom.gunkul.com/login" target="_blank"><i class="fa fa-users text-primary"></i> จองห้องประชุม</a></li>
                    <li><a href="https://edoc.gunkul.com/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ e-Doc GKE</a></li>
                    <li><a href="https://edocgka.gunkul.com/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ e-Doc GKA, P</a></li>
                    <li><a href="https://edoc.gpdpublic.com/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ e-Doc GPD</a></li>
                    <li><a href="https://edocjv.gunkul.com/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ e-Doc JV</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="https://edocdev.gunkul.com/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc GKE</a></li>
                    <li><a href="https://gkadev.gunkul.com/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc GKA, P</a></li>
                    <li><a href="https://10.10.9.183:8443/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc GPD</a></li>
                    <li><a href="https://http://10.10.9.166:8080/share/page" target="_blank"><i class="fa fa-cogs text-primary"></i> ระบบ Dev e-Doc JV</a></li>
                </ul>
            </li>
        </ul> -->
        <!-- <div class="btn-lg-square bg-primary rounded-circle"><i class=" fa fa-chevron-right text-white "></i></div> -->
    <!-- </div> -->
    <!-- <a href="Ui_ListAdmin.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block"><i class="fa fa-arrow-right ms-3"></i></a> -->
    <!-- <div style="margin-left: 100px;" class="btn-lg-square bg-primary rounded-circle"><i class=" fa fa-chevron-right text-white "></i></div> -->
<!-- </div>  -->

    </nav>
    <!-- Navbar End -->