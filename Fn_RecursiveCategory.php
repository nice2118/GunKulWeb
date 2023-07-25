<?php
//      3
//   5     6
//        8  9
function SearchCategory($GroupCategory) {   //3,5,6,8,9
    global $conn;
    $SelectCategory = '';
    $sql = "SELECT `CG_Entity No.` FROM `Category` WHERE `CG_Entity Relation No.` = $GroupCategory";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
            unset($Temp);
            $Temp = SearchCategory($row["CG_Entity No."]);
            if ($SelectCategory == '') {
                $SelectCategory .= $GroupCategory.',' . $Temp;
            } else {
                $SelectCategory .= ',' . $Temp;
            }
        } 
    } else {
        if ($SelectCategory == '') {
            $SelectCategory = $GroupCategory;
        } else {
            $SelectCategory .= ',' . $GroupCategory;
        }
    }
    return $SelectCategory;
}

function SearchCategorySub($GroupCategory) {    //5,8,9     เคสนี้กรณีเมื่อมีหัวแค่ตัวเดียวจะแสดงแค่หัว 1 ตัว
    global $conn;
    $SelectCategory = '';
    
    $sql = "SELECT `CG_Entity No.` FROM `Category` WHERE `CG_Entity Relation No.` = $GroupCategory";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            unset($Temp);
            $Temp = SearchCategorySub($row["CG_Entity No."]);
            if ($SelectCategory == '') {
                $SelectCategory = $Temp;
            } else {
                $SelectCategory .= ',' . $Temp;
            }
        } 
    } else {
        if ($SelectCategory == '') {
            $SelectCategory = $GroupCategory;
        } else {
            $SelectCategory .= ',' . $GroupCategory;
        }
    }
    return $SelectCategory;
}

function SearchCategorySubNotHeader($GroupCategory) {    //5,8,9  เคสนี้กรณีเมื่อมีหัวแค่ตัวเดียวจะไม่แสดง
    global $conn;
    $SelectCategory = '';
    
    $sql = "SELECT `CG_Entity No.` FROM `Category` WHERE `CG_Entity Relation No.` = $GroupCategory";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            unset($Temp);
            $Temp = SearchCategorySub($row["CG_Entity No."]);
            if ($SelectCategory == '') {
                $SelectCategory = $Temp;
            } else {
                $SelectCategory .= ',' . $Temp;
            }
        } 
    } else {
        if ($SelectCategory == '') {
            // $SelectCategory = $GroupCategory;
        } else {
            $SelectCategory .= ',' . $GroupCategory;
        }
    }
    return $SelectCategory;
}

function SearchCategoryReturn($GroupCategory) {  // Send 9  = 9 6 3
    global $conn;
    $SelectCategory = '';

    $sql = "SELECT `CG_Entity Relation No.` FROM `Category` WHERE `CG_Entity No.` = $GroupCategory";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Temp = SearchCategoryReturn($row["CG_Entity Relation No."]);
            if ($Temp != '') {
                if ($SelectCategory == '') {
                    $SelectCategory .= $Temp;
                } else {
                    $SelectCategory .= ' ' . $Temp;
                }
            }
        }
        $SelectCategory = $GroupCategory . ' ' . $SelectCategory;
    } else {
        $SelectCategory = $GroupCategory;
    }

    if ($SelectCategory == '0') {
        $SelectCategory = '';
    }

    return $SelectCategory;
}

function SearchCategoryReturnNotBegin($GroupCategory) {  // Send 9  = 9 6
    global $conn;
    $SelectCategory = '';

    $sql = "SELECT `CG_Entity Relation No.` FROM `Category` WHERE `CG_Entity No.` = $GroupCategory AND `CG_Entity Relation No.` != 0";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Temp = SearchCategoryReturnNotBegin($row["CG_Entity Relation No."]);
            if ($Temp != '') {
                if ($SelectCategory == '') {
                    $SelectCategory .= $Temp;
                } else {
                    $SelectCategory .= ' ' . $Temp;
                }
            }
        }
        $SelectCategory = $GroupCategory . ' ' . $SelectCategory;
    } else {
        // $SelectCategory = $GroupCategory;
    }

    if ($SelectCategory == '0') {
        $SelectCategory = '';
    }

    return $SelectCategory;
}

?>