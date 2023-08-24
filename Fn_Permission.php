
<?php
function CheckAdmin($Req_User) {
    global $conn;
    $SendStatus = false;
    
    $sql = "SELECT * FROM `setposition` WHERE `setposition`.`US_Username` = '$Req_User' ;";
    $result = $conn->query($sql);                 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sql2 = "SELECT * FROM `position` WHERE `position`.`PT_Code` = '{$row["PT_Code"]}' AND `position`.`PT_Admin` = 1 ;";
            $result2 = $conn->query($sql2);                 
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    $SendStatus = true;
                }
            }
        }
    }
    return $SendStatus;
}

function CheckStatus($Req_User, $Req_PermissionMenu) {
    global $conn;

    $isAccess = false;
    $setPositions = array();
    $sqlPositions = "SELECT * FROM `setposition` WHERE `setposition`.`US_Username` = '$Req_User';";
    $resultPositions = $conn->query($sqlPositions);
    if ($resultPositions->num_rows > 0) {
        while ($rowPosition = $resultPositions->fetch_assoc()) {
            $sqlP = "SELECT * FROM `position` WHERE `position`.`PT_Code` = '{$rowPosition["PT_Code"]}' AND `position`.`PT_Admin` = 1;";
            $resultP = $conn->query($sqlP);
            if ($resultP->num_rows > 0) {
                $rowP = $resultP->fetch_assoc();
                $isAccess = true;
            }
            $setPositions[] = $rowPosition["PT_Code"];
        }
    }


    $permissionPositions = array();
    $sqlPermissionPositions = "SELECT * FROM `permissionposition` WHERE `permissionposition`.`PM_Code` = '$Req_PermissionMenu';";
    $resultPermissionPositions = $conn->query($sqlPermissionPositions);
    if ($resultPermissionPositions->num_rows > 0) {
        while ($rowPermissionPosition = $resultPermissionPositions->fetch_assoc()) {
            if ($rowPermissionPosition["PP_Type"] == 'single') {
                $permissionPositions[] = $rowPermissionPosition["PT_Code"];
            } elseif ($rowPermissionPosition["PP_Type"] == 'multi') {
                $sqlGroupPositionLine = "SELECT * FROM `grouppositionline` WHERE `grouppositionline`.`GH_Code` = '{$rowPermissionPosition["PT_Code"]}';";
                $resultGroupPositionLine = $conn->query($sqlGroupPositionLine);
                if ($resultGroupPositionLine->num_rows > 0) {
                    while ($rowGroupPositionLine = $resultGroupPositionLine->fetch_assoc()) {
                        $permissionPositions[] = $rowGroupPositionLine["PT_Code"];
                    }
                }
            }
        }
    }

    // echo "<br>setPositions: ";
    // print_r($setPositions);
    // echo "<br>permissionPositions: ";
    // print_r($permissionPositions);
    
    $hasPermission = false;
    if (empty($permissionPositions)) {
        $hasPermission = true;
    } else {
        foreach ($permissionPositions as $permission) {
            if (in_array($permission, $setPositions)) {
                $hasPermission = true;
                break;
            }
        }
    }
    if ($isAccess){     // แอดมินทะลุ
        $hasPermission = true;
    }

    return $hasPermission;
}