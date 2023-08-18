<?PHP
    include("Fn_SearchPathNameLast.php"); 
    $categories = array();
    $menuCategories = array();
?>
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
                    $sql = "SELECT * FROM `Menu`;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                ?>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?= $row["MN_Name"] ?></a>
                    <?php
                        $sql = "SELECT * FROM `PermissionMenu` WHERE `PermissionMenu`.`PM_RelationPermission` = 0 AND `PermissionMenu`.`PM_Menu` = " . $row["MN_Code"];
                        $resultSub = $conn->query($sql);
                        if ($resultSub->num_rows > 0) {
                            echo '<div class="dropdown-menu bg-light m-0">';
                            while ($rowSub = $resultSub->fetch_assoc()) {
                                $typeLower = strtolower($rowSub["PM_RelationType"]);
                                if ($typeLower === 'category') {
                                    $sql = "SELECT * FROM `category` WHERE `CG_Entity No.` =" . $rowSub["PM_RelationCode"];
                                    $resultcategory = $conn->query($sql);
                                    if ($resultcategory->num_rows > 0) {
                                        while ($rowcategory = $resultcategory->fetch_assoc()){
                                            if ($rowSub["PM_Setup"] == 1) {
                                                if(!isset($_SESSION['User']) || $_SESSION['User'] === '') {
                                        
                                                } else {
                                                    echo '<a href="Ui_ListAdmin.php?Send_Category=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                                }
                                            } elseif ($rowSub["PM_Setup"] == 0) {
                                                if ($rowcategory["CG_IsFile"] == 0) {
                                                    echo '<a href="Ui_ShowPage.php?Send_Category=' . $rowSub["PM_RelationCode"] . '&Multiplier=1&Search=" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                                } elseif ($rowcategory["CG_IsFile"] == 1) {
                                                    echo '<a href="Ui_List.php?Send_Category=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                                }
                                            }
                                        }
                                    }
                                } elseif ($typeLower === 'headingcategories') {
                                    if ($rowSub["PM_Setup"] == 1) {
                                        if(!isset($_SESSION['User']) || $_SESSION['User'] === '') {
                                        
                                        } else {
                                            echo '<a href="Ui_ListAdminMenuCategories.php?Send_MenuCategory=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                        }
                                    } elseif ($rowSub["PM_Setup"] == 0) {  
                                        echo '<a href="Ui_ShowPageMenu.php?Send_MoreMenu=' . $rowSub["PM_RelationCode"] . '" class="dropdown-item">' . $rowSub["PM_Name"] . '</a>';
                                    }
                                } elseif ($typeLower === 'engravedcategory') {
                                    $sql = "SELECT * FROM `engravedactivities` WHERE `EC_Code` =" . $rowSub["PM_RelationCode"];
                                    $resultengravedactivities = $conn->query($sql);
                                    if ($resultengravedactivities->num_rows > 0) {
                                        if ($resultengravedactivities->num_rows > 1) {
                                            echo '<nav>';
                                            echo '<a href="" class="dropdown-item">'.$rowSub['PM_Name'].'&nbsp;&nbsp;<i class="fa fa-angle-down text-secondary2"></i></a>';
                                            echo '<ul class="dropdown-menu-submenu submenu submenu-'.$rowSub['PM_Direction'].'">';
                                            while ($rowengravedactivities = $resultengravedactivities->fetch_assoc()){
                                                echo "<a href=\"$link\" class=\"dropdown-item\">{$rowengravedactivities['EA_Name']}</a>";  
                                            }  
                                            echo '</ul>';
                                            echo '</nav>';
                                        } else {
                                            $rowengravedactivities = $resultengravedactivities->fetch_assoc();
                                            $link = PDFNamePathLast($rowengravedactivities["EA_Path"]);
                                            echo "<a href=\"$link\" class=\"dropdown-item\">{$rowengravedactivities['EA_Name']}</a>";  
                                        }                                    
                                    }
                                } elseif ($typeLower === 'setupgames') {
                                    echo "<a href=\"Ui_Activity.php\" class=\"dropdown-item\">{$rowSub['PM_Name']}</a>";
                                } elseif ($typeLower === 'setup') {
                                    if(!isset($_SESSION['User']) || $_SESSION['User'] === '') {

                                    } else {
                                        echo "<a href=\"Ui_AdminSetup.php\" class=\"dropdown-item\">{$rowSub['PM_Name']}</a>";
                                    }
                                }
                                if ($rowSub["PM_Draw"] == 1) { echo '<li><hr class="dropdown-divider"></li>'; }
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
            <?php if(!isset($_SESSION['User']) || $_SESSION['User'] === '') : ?>
            <button class="btn btn-white rounded-0 py-4 px-lg-3 d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#LoginModal"><i class="fa fa-user-circle ms-auto fs-4"></i></button>
            <?php else: ?>
            <a class="btn btn-white rounded-0 py-4 px-lg-3 d-none d-lg-block" onclick="logoutAlert()"><i class="fas fa-sign-out-alt ms-auto fs-5"></i></a>
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