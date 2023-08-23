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
?>