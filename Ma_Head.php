<?PHP
    include("Fn_SearchPathNameLast.php"); 
    $categories = array();
    $menuCategories = array();
?>
<?php include("Fn_Permission.php"); ?>
<style>
  #Profile_imageUser, #SignUp_imageUser{
    display: none;
  }
</style>
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

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="Index.php" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
            <img class="img-fluid" src="Default\Logo\GKE.png" style="width:200px;" />
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <?php
                    $sql = "SELECT * FROM `Menu`";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?= $row["MN_Name"]; ?> </a>
                    <?php
                        $sql = "SELECT * FROM `PermissionMenu` WHERE `PermissionMenu`.`PM_RelationPermission` = 0 AND `PermissionMenu`.`PM_Menu` = " . $row["MN_Code"];
                        $resultSub = $conn->query($sql);
                        if ($resultSub->num_rows > 0) {
                            echo '<div class="dropdown-menu bg-light m-0">';
                            while ($rowSub = $resultSub->fetch_assoc()) {
                                if (CheckStatus($currentUser,$rowSub["PM_Code"])) {
                                    $typeLower = strtolower($rowSub["PM_RelationType"]);
                                    if ($typeLower === 'category') {
                                        $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` =" . $rowSub["PM_RelationCode"];
                                        $resultcategory = $conn->query($sql);
                                        if ($resultcategory->num_rows > 0) {
                                            $rowcategory = $resultcategory->fetch_assoc();
                                            if ($rowSub["PM_Setup"] == 1) {
                                                if(isset($currentUser) && $currentUser != '') {
                                                    if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                    echo '<a href="Ui_ListAdmin.php?Send_Category=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                                }
                                            } elseif ($rowSub["PM_Setup"] == 0) {
                                                if ($rowcategory["CG_IsFile"] == 0) {
                                                    if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                    echo '<a href="Ui_ShowPage.php?Send_Category=' . $rowSub["PM_RelationCode"] . '&Multiplier=1&Search=" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                                } elseif ($rowcategory["CG_IsFile"] == 1) {
                                                    if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                    echo '<a href="Ui_List.php?Send_Category=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                                }
                                            } 
                                        }
                                    } elseif ($typeLower === 'headingcategories') {
                                        if ($rowSub["PM_Setup"] == 1) {
                                            if(isset($currentUser) && $currentUser != '') {
                                                if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                echo '<a href="Ui_ListAdminMenuCategories.php?Send_MenuCategory=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                            }
                                        } elseif ($rowSub["PM_Setup"] == 0) {  
                                            if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                            echo '<a href="Ui_ShowPageMenu.php?Send_MoreMenu=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                        }
                                    } elseif ($typeLower === 'engravedcategory') {
                                        $sql = "SELECT * FROM `engravedactivities` WHERE `EC_Code` =" . $rowSub["PM_RelationCode"];
                                        $resultengravedactivities = $conn->query($sql);
                                        if ($resultengravedactivities->num_rows > 0) {
                                            if ($rowSub["PM_Setup"] == 1) {
                                                if(isset($currentUser) && $currentUser != '') {
                                                    if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                    if ($resultengravedactivities->num_rows > 1) {
                                                        echo '<nav>';
                                                        echo '<a href="#" class="dropdown-item">'.$rowSub['PM_Name'].'&nbsp;&nbsp;<i class="fa fa-angle-down text-secondary2"></i></a>';
                                                        echo '<ul class="dropdown-menu-submenu submenu submenu-'.$rowSub['PM_Direction'].'">';
                                                        while ($rowengravedactivities = $resultengravedactivities->fetch_assoc()){
                                                            $link = PDFNamePathLast($rowengravedactivities["EA_Path"]);
                                                            echo "<a href=\"$link\" target=\"_blank\" class=\"dropdown-item\">{$rowengravedactivities['EA_Name']}</a>";  
                                                        }  
                                                        echo '</ul>';
                                                        echo '</nav>';
                                                    } else if ($resultengravedactivities->num_rows == 1) {
                                                        $rowengravedactivities = $resultengravedactivities->fetch_assoc();
                                                        $link = PDFNamePathLast($rowengravedactivities["EA_Path"]);
                                                        echo "<a href=\"$link\" target=\"_blank\" class=\"dropdown-item\">{$rowengravedactivities['EA_Name']}</a>";  
                                                    } 
                                                }
                                            } elseif ($rowSub["PM_Setup"] == 0) {  
                                                if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                if ($resultengravedactivities->num_rows > 1) {
                                                    echo '<nav>';
                                                    echo '<a href="#" class="dropdown-item">'.$rowSub['PM_Name'].'&nbsp;&nbsp;<i class="fa fa-angle-down text-secondary2"></i></a>';
                                                    echo '<ul class="dropdown-menu-submenu submenu submenu-'.$rowSub['PM_Direction'].'">';
                                                    while ($rowengravedactivities = $resultengravedactivities->fetch_assoc()){
                                                        $link = PDFNamePathLast($rowengravedactivities["EA_Path"]);
                                                        echo "<a href=\"$link\" target=\"_blank\" class=\"dropdown-item\">{$rowengravedactivities['EA_Name']}</a>";  
                                                    }  
                                                    echo '</ul>';
                                                    echo '</nav>';
                                                } else if ($resultengravedactivities->num_rows == 1) {     
                                                    $rowengravedactivities = $resultengravedactivities->fetch_assoc();
                                                    $link = PDFNamePathLast($rowengravedactivities["EA_Path"]);
                                                    echo "<a href=\"$link\" target=\"_blank\" class=\"dropdown-item\">{$rowengravedactivities['EA_Name']}</a>";  
                                                } 
                                            }                                   
                                        }
                                    } elseif ($typeLower === 'setupgames') {
                                        if ($rowSub["PM_Setup"] == 1) {
                                            if(isset($currentUser) && $currentUser != '') {
                                                if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                echo "<a href=\"Ui_Activity.php\" class=\"dropdown-item\">{$rowSub['PM_Name']}</a>";
                                            }
                                        } elseif ($rowSub["PM_Setup"] == 0) {  
                                            if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                            echo "<a href=\"Ui_Activity.php\" class=\"dropdown-item\">{$rowSub['PM_Name']}</a>";
                                        }
                                    } elseif ($typeLower === 'setup') {
                                        if ($rowSub["PM_Setup"] == 1) {
                                            if(isset($currentUser) && $currentUser != '') {
                                                if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                                echo "<a href=\"Ui_AdminSetup.php\" class=\"dropdown-item\">{$rowSub['PM_Name']}</a>";
                                            }
                                        } elseif ($rowSub["PM_Setup"] == 0) {  
                                            if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                            echo "<a href=\"Ui_AdminSetup.php\" class=\"dropdown-item\">{$rowSub['PM_Name']}</a>";
                                        }
                                    } elseif ($typeLower === 'notype') {
                                        if ($rowSub["PM_Setup"] == 1) {
                                            if(isset($currentUser) && $currentUser != '') {
                                                generateSubMenu($rowSub);
                                            }
                                        } elseif ($rowSub["PM_Setup"] == 0) {  
                                            generateSubMenu($rowSub);
                                        }
                                    }
                                    // if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                }
                            }
                            echo '</div>';
                        }
                    ?>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
            <?php if(!isset($currentUser) || $currentUser === '') : ?>
                <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Log Out">
                    <button type="button" class="btn btn-white rounded-0 py-4 px-lg-3 d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#LoginModal"><i class="fa fa-user-circle ms-auto fs-4"></i></button>
                </div>
                <div data-bs-toggle="tooltip" data-bs-placement="left" title="Sign Up">
                    <button type="button" class="btn btn-white rounded-0 py-4 px-lg-3 d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#SignUpModal"><i class="fa fa-user-plus ms-auto fs-5"></i></button>
                </div>
            <?php else: ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-white rounded-0 py-3 px-lg-3 d-none d-lg-block dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <?PHP
                            $Profile_Prefix = '';
                            $Profile_Fname = '';
                            $Profile_Lname = '';
                            $Profile_Username = '';
                            $Profile_Password = '';
                            $Profile_Position = '';
                            $Profile_Image = '';
                            $ImageProfile = 'Default/DefaultUser/0.png';
                            $Profile_Position = '';
                            $sql = "SELECT * FROM `user` WHERE `user`.`US_Username` = '{$currentUser}'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $Profile_Prefix = $row["US_Prefix"];
                                $Profile_Fname = $row["US_Fname"];
                                $Profile_Lname = $row["US_Lname"];
                                $Profile_Username = $row["US_Username"];
                                $Profile_Password = $row["US_Password"];
                                if ($row["US_Image"] != ''){
                                    $Profile_Image = 'img/User/'.$row["US_Image"];
                                    $ImageProfile = 'img/User/'.$row["US_Image"];
                                }
                                $sqlPosition = "SELECT `PT_Name` FROM `setposition` LEFT JOIN `position` ON `setposition`.`PT_Code` = `position`.`PT_Code` WHERE `setposition`.`US_Username` = '{$currentUser}'";
                                $resultPosition = $conn->query($sqlPosition);
                                if ($resultPosition->num_rows > 0) {
                                    while ($rowPosition = $resultPosition->fetch_assoc()) {
                                        if ($Profile_Position == '') {
                                            $Profile_Position = $rowPosition["PT_Name"];
                                        } else {
                                            $Profile_Position .= ', '.$rowPosition["PT_Name"];
                                        }
                                    }
                                }
                            }
                        ?>
                        <img id="previewImageUser" class="img-fluid rounded-circle mx-1 mb-1" src="<?=$ImageProfile?>" alt="" style="width: 40px; height: 40px;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-lg-end my-0">
                        <li><button type="button" class="btn btn-white rounded-0 py-3 px-lg-3 d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#ProfileModal"><i class="fa fa-user-circle ms-auto fs-5"></i>&nbsp;จัดการโปรไฟล์</button></li>
                        <li><button type="button" class="btn btn-white rounded-0 py-3 px-lg-3 d-none d-lg-block" onclick="logoutAlert('<?=$currentUser?>')"><i class="fas fa-sign-out-alt ms-auto fs-5"></i>&nbsp;ออกจากระบบ</button></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->

<!-- Modal Login-->
<div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="LoginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="modalFormLogin">
          <div class="mb-3">
            <label for="user" class="form-label">User</label>
            <input type="text" id="user" name="user" class="form-control border-1" placeholder="User" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control border-1" placeholder="Password" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="modalFormLogin" class="btn btn-primary">Sign In</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal SignUp-->
<div class="modal fade" id="SignUpModal" tabindex="-1" aria-labelledby="SignUpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="SignUpModalLabel">Sign Up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="modalFormSignUp" action="Pro_AddSignUp.php" method="post" enctype="multipart/form-data">
            <div class="row g-2 my-2">
                <div class="col-2 col-sm-2">
                    <h6 class="text-primary">คำนำหน้า</h6>
                    <select class="form-select border-1" name="SignUp_Prefix" >
                        <option value="">เลือกคำนำหน้า</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-5 col-sm-5">
                    <h6 class="text-primary">ชื่อ</h6>
                    <input type="Text" name="SignUp_Fname" class="form-control border-1" placeholder="ชื่อ" required>
                </div>
                <div class="col-5 col-sm-5">
                    <h6 class="text-primary">นามสกุล</h6>
                    <input type="Text" name="SignUp_Lname" class="form-control border-1" placeholder="นามสกุล">
                </div>
                <div class="col-6 col-sm-6">
                    <h6 class="text-primary">Username</h6>
                    <input type="Text" name="SignUp_Username" class="form-control border-1" placeholder="Username" required>
                </div>
                <div class="col-6 col-sm-6">
                </div>
                <div class="col-6 col-sm-6">
                    <h6 class="text-primary">Password</h6>
                    <input type="Password" name="SignUp_Password" class="form-control border-1" placeholder="Password" required>
                </div>
                <div class="col-6 col-sm-6">
                    <h6 class="text-primary">Confirm Password</h6>
                    <input type="Password" name="SignUp_ConfirmPassword" class="form-control border-1" placeholder="Confirm Password" required>
                </div>
                <div class="col-6 col-sm-6">
                    <h6 class="text-primary">ภาพเริ่มต้น</h6>
                    <input type="file" class="form-control border-1" name="SignUp_imageUser" id="SignUp_imageUser" accept="image/*">
                    <label for="SignUp_imageUser" style="cursor: pointer;">
                        <img id="previewImageUserSignUp" class="img-fluid rounded" src="Default/DefaultUser/0.png" alt="" style="width: 75px; height: 75px;">
                    </label>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="modalFormSignUp" class="btn btn-primary">Sign Up</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Profile-->
<div class="modal fade" id="ProfileModal" tabindex="-1" aria-labelledby="ProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProfileModalLabel">Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="modalFormProfile" action="Pro_EditProfile.php" method="post" enctype="multipart/form-data">
            <div class="row g-2 my-2">
                <input type="hidden" name="Profile_Image" class="form-control border-1" placeholder="0" value="<?=$Profile_Image?>" readonly>
                <input type="hidden" name="Profile_UsernameOld" class="form-control border-1" placeholder="" value="<?=$Profile_Username?>" readonly>
                <div class="col-2 col-sm-2">
                    <h6 class="text-primary">คำนำหน้า</h6>
                    <select class="form-select border-1" name="Profile_Prefix">
                        <option value="">เลือกคำนำหน้า</option>
                        <option value="นาย" <?php if ('นาย' == $Profile_Prefix) echo 'selected'; ?>>นาย</option>
                        <option value="นาง" <?php if ('นาง' == $Profile_Prefix) echo 'selected'; ?>>นาง</option>
                        <option value="นางสาว" <?php if ('นางสาว' == $Profile_Prefix) echo 'selected'; ?>>นางสาว</option>
                    </select>
                </div>
                <div class="col-5 col-sm-5">
                    <h6 class="text-primary">ชื่อ</h6>
                    <input type="Text" name="Profile_Fname" class="form-control border-1" placeholder="ชื่อ" value="<?=$Profile_Fname?>" required>
                </div>
                <div class="col-5 col-sm-5">
                    <h6 class="text-primary">นามสกุล</h6>
                    <input type="Text" name="Profile_Lname" class="form-control border-1" placeholder="นามสกุล" value="<?=$Profile_Lname?>">
                </div>
                <div class="col-12 col-sm-12">
                    <h6 class="text-primary">Username</h6>
                    <input type="Text" name="Profile_Username" class="form-control border-1" placeholder="Username" value="<?=$Profile_Username?>" required>
                </div>
                <div class="col-6 col-sm-6">
                    <div class="row">
                        <div class="col-12 col-sm-12 my-2">
                            <h6 class="text-primary">Old Password</h6>
                            <input type="Password" name="Profile_PasswordOld" class="form-control border-1" placeholder="Old Password" value="">
                        </div>
                        <div class="col-12 col-sm-12 my-2">
                            <h6 class="text-primary">New Password</h6>
                            <input type="Password" name="Profile_Password" class="form-control border-1" placeholder="New Password" value="">
                        </div>
                        <div class="col-12 col-sm-12 my-2">
                            <h6 class="text-primary">Confirm Password</h6>
                            <input type="Password" name="Profile_ConfirmPassword" class="form-control border-1" placeholder="Confirm Password" value="">
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6">
                    <div class="row">
                        <div class="col-12 col-sm-12 my-2">
                            <h6 class="text-primary">ภาพเริ่มต้น</h6>
                            <input type="file" class="form-control border-1" name="Profile_imageUser" id="Profile_imageUser" accept="image/*">
                            <label for="Profile_imageUser" style="cursor: pointer;">
                                <img id="previewImageUserProfile" class="img-fluid rounded" src="<?=$ImageProfile?>" alt="" style="width: 75px; height: 75px;">
                            </label>
                        </div>
                        <div class="col-12 col-sm-12 my-2">
                            <h6 class="text-primary">ตำแหน่ง</h6>
                            <p><?=$Profile_Position?></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="modalFormProfile" class="btn btn-primary">บันทึก</button>
      </div>
    </div>
  </div>
</div>

<?php
function generateSubMenu($rowSub) {
    global $conn,$currentUser;
    $firstTime = true;
    $finishTime = false;

    $sql = "SELECT * FROM `PermissionMenu` WHERE `PermissionMenu`.`PM_RelationPermission` = " . $rowSub["PM_Code"];
    $resultSub2 = $conn->query($sql);
    if ($resultSub2->num_rows > 0) {
        while ($rowSub2 = $resultSub2->fetch_assoc()){
            if (CheckStatus($currentUser,$rowSub2["PM_Code"])) {
                if ($firstTime) {
                    if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                    echo '<nav>';
                    echo '<a href="#" class="dropdown-item">'.$rowSub['PM_Name'].'&nbsp;&nbsp;<i class="fa fa-angle-down text-secondary2"></i></a>';
                    echo '<ul class="dropdown-menu-submenu submenu submenu-'.$rowSub['PM_Direction'].'">';
                    $firstTime = false;
                    $finishTime = true;
                }
                $typeLowerSub2 = strtolower($rowSub2["PM_RelationType"]);
                if ($typeLowerSub2 === 'category') {
                    $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` =" . $rowSub2["PM_RelationCode"];
                    $resultcategorySub2 = $conn->query($sql);
                    if ($resultcategorySub2->num_rows > 0) {
                        $rowcategorySub2 = $resultcategorySub2->fetch_assoc();
                        if ($rowSub2["PM_Setup"] == 1) {
                            if(isset($currentUser) && $currentUser != '') {
                                if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                echo '<a href="Ui_ListAdmin.php?Send_Category=' . $rowSub2["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub2["PM_Name"] . '</a>';
                            }
                        } elseif ($rowSub2["PM_Setup"] == 0) {
                            if ($rowcategorySub2["CG_IsFile"] == 0) {
                                if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                echo '<a href="Ui_ShowPage.php?Send_Category=' . $rowSub2["PM_RelationCode"] . '&Multiplier=1&Search=" class="dropdown-item">' . $rowSub2["PM_Name"] . '</a>';
                            } elseif ($rowcategorySub2["CG_IsFile"] == 1) {
                                if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                                echo '<a href="Ui_List.php?Send_Category=' . $rowSub2["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub2["PM_Name"] . '</a>';
                            }
                        }
                    }
                } elseif ($typeLowerSub2 === 'headingcategories') {
                    if ($rowSub2["PM_Setup"] == 1) {
                        if(isset($currentUser) && $currentUser != '') {
                            if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                            echo '<a href="Ui_ListAdminMenuCategories.php?Send_MenuCategory=' . $rowSub2["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub2["PM_Name"] . '</a>';
                        }
                    } elseif ($rowSub2["PM_Setup"] == 0) {  
                        if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                        echo '<a href="Ui_ShowPageMenu.php?Send_MoreMenu=' . $rowSub2["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub2["PM_Name"] . '</a>';
                    }
                } elseif ($typeLowerSub2 === 'setupgames') {
                    if ($rowSub2["PM_Setup"] == 1) {
                        if(isset($currentUser) && $currentUser != '') {
                            if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                            echo "<a href=\"Ui_Activity.php\" class=\"dropdown-item\">{$rowSub2['PM_Name']}</a>";
                        }
                    } elseif ($rowSub2["PM_Setup"] == 0) {  
                        if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                        echo "<a href=\"Ui_Activity.php\" class=\"dropdown-item\">{$rowSub2['PM_Name']}</a>";
                    }
                } elseif ($typeLowerSub2 === 'setup') {
                    if ($rowSub2["PM_Setup"] == 1) {
                        if(isset($currentUser) && $currentUser != '') {
                            if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                            echo "<a href=\"Ui_AdminSetup.php\" class=\"dropdown-item\">{$rowSub2['PM_Name']}</a>";
                        }
                    } elseif ($rowSub2["PM_Setup"] == 0) {  
                        if ($rowSub2["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
                        echo "<a href=\"Ui_AdminSetup.php\" class=\"dropdown-item\">{$rowSub2['PM_Name']}</a>";
                    }
                }
            }
        }  
    }  
    if ($finishTime) {
        echo '</ul>';
        echo '</nav>';
    }
}
?>