<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectElements = [
        document.getElementById('IS_GroupMenu1'),
        document.getElementById('IS_GroupMenu2'),
        document.getElementById('IS_GroupMenu3'),
        document.getElementById('IS_GroupMenu4')
    ];

    var boxIds = ['IS_Box1', 'IS_Box2', 'IS_Box3', 'IS_Box4'];
    var groupMenuBoxIds = ['IS_GroupMenu1_Box1', 'IS_GroupMenu2_Box2', 'IS_GroupMenu3_Box3', 'IS_GroupMenu4_Box4'];
    var groupMenuNames = ['กลุ่มย่อยที่ 1', 'กลุ่มย่อยที่ 2', 'กลุ่มย่อยที่ 3', 'กลุ่มย่อยที่ 4'];

    for (var i = 0; i < selectElements.length; i++) {
        var selectElement = selectElements[i];
        var boxId = boxIds[i];
        var groupMenuBoxId = groupMenuBoxIds[i];
        var groupMenuName = groupMenuNames[i];
        addOptionsToBoxDiv(selectElement.value, boxId, groupMenuBoxId, groupMenuName);
    }
});

document.getElementById('IS_GroupMenu1').addEventListener('change', function() {
    var selectElement = document.getElementById('IS_GroupMenu1');
    addOptionsToBoxDiv(selectElement.value,'IS_Box1','IS_GroupMenu1_Box1','กลุ่มย่อยที่ 1');
});
document.getElementById('IS_GroupMenu2').addEventListener('change', function() {
    var selectElement = document.getElementById('IS_GroupMenu2');
    addOptionsToBoxDiv(selectElement.value,'IS_Box2','IS_GroupMenu2_Box2','กลุ่มย่อยที่ 2');
});
document.getElementById('IS_GroupMenu3').addEventListener('change', function() {
    var selectElement = document.getElementById('IS_GroupMenu3');
    addOptionsToBoxDiv(selectElement.value,'IS_Box3','IS_GroupMenu3_Box3','กลุ่มย่อยที่ 3');
});
document.getElementById('IS_GroupMenu4').addEventListener('change', function() {
    var selectElement = document.getElementById('IS_GroupMenu4');
    addOptionsToBoxDiv(selectElement.value,'IS_Box4','IS_GroupMenu4_Box4','กลุ่มย่อยที่ 4');
});

// ฟังก์ชันเพิ่มข้อมูลใน div ที่เหมาะสม
function addOptionsToBoxDiv(selectedValue, ISBox, ISGroupMenuBox, ISName) {
    var boxDiv = document.getElementById(ISBox);
    var contentHTML = `
        <div class="form-group my-3">
            <label for="PathFolderNews">${ISName}</label>
            <select class="form-select border-1" id="${ISGroupMenuBox}" name="${ISGroupMenuBox}">
                <option></option>
    `;
    switch (ISBox) {
        case 'IS_Box1':
                    if (selectedValue === 'category') {
                    <?php
                        $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu1 == 'category') {
                                    $selected = ($row["CG_Entity No."] == $ISGroupMenu1_Box1) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["CG_Entity No."]?>" <?= $selected ?>><?=$row["CG_Name"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else if (selectedValue === 'headingcategories') {
                    <?php
                        $sql = "SELECT * FROM `HeadingCategories`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu1 == 'headingcategories') {
                                    $selected = ($row["HC_Code"] == $ISGroupMenu1_Box1) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["HC_Code"]?>" <?= $selected ?>><?=$row["HC_Text"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else {
                    contentHTML = '';
                }
            break;
        case 'IS_Box2':
            if (selectedValue === 'category') {
                    <?php
                        $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu2 == 'category') {
                                    $selected = ($row["CG_Entity No."] == $ISGroupMenu2_Box2) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["CG_Entity No."]?>" <?= $selected ?>><?=$row["CG_Name"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else if (selectedValue === 'headingcategories') {
                    <?php
                        $sql = "SELECT * FROM `HeadingCategories`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu2 == 'headingcategories') {
                                    $selected = ($row["HC_Code"] == $ISGroupMenu2_Box2) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["HC_Code"]?>" <?= $selected ?>><?=$row["HC_Text"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else {
                    contentHTML = '';
                }
            break;

        case 'IS_Box3':
            if (selectedValue === 'category') {
                    <?php
                        $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu3 == 'category') {
                                    $selected = ($row["CG_Entity No."] == $ISGroupMenu3_Box3) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["CG_Entity No."]?>" <?= $selected ?>><?=$row["CG_Name"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else if (selectedValue === 'headingcategories') {
                    <?php
                        $sql = "SELECT * FROM `HeadingCategories`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu3 == 'headingcategories') {
                                    $selected = ($row["HC_Code"] == $ISGroupMenu3_Box3) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["HC_Code"]?>" <?= $selected ?>><?=$row["HC_Text"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else {
                    contentHTML = '';
                }
            break;

        case 'IS_Box4':
            if (selectedValue === 'category') {
                    <?php
                        $sql = "SELECT * FROM `category` WHERE `CG_Entity Relation No.` = 0;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu4 == 'category') {
                                    $selected = ($row["CG_Entity No."] == $ISGroupMenu4_Box4) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["CG_Entity No."]?>" <?= $selected ?>><?=$row["CG_Name"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else if (selectedValue === 'headingcategories') {
                    <?php
                        $sql = "SELECT * FROM `HeadingCategories`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if ($ISGroupMenu4 == 'headingcategories') {
                                    $selected = ($row["HC_Code"] == $ISGroupMenu4_Box4) ? 'selected' : '';
                                }
                    ?>
                    contentHTML += `<option value="<?=$row["HC_Code"]?>" <?= $selected ?>><?=$row["HC_Text"]?></option>`;
                    <?php
                            }
                        }
                    ?>
                    contentHTML += `</select></div>`;
                } else {
                    contentHTML = '';
                }
            break;
    }
    boxDiv.innerHTML = contentHTML;
}
</script>