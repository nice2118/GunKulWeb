<?php
function SearchCategory($GroupCategory) {
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

function SearchCategorySub($GroupCategory) {
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

?>