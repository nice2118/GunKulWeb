    <?php
    include("DB_Include.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // เก็บข้อมูลจากฟอร์ม
        $GH_Code = $_POST['GH_Code'];
        $GH_Name = $_POST['GH_Name'];
        // Array
        $GL_Code = isset($_POST['GL_Code']) ? $_POST['GL_Code'] : array();

        if ($GH_Code == 0 || $GH_Code == '') {
            $sql = "INSERT INTO GroupPositionHeader (GH_Name) VALUES ('$GH_Name')";
        } else {
            $sql = "UPDATE GroupPositionHeader SET GH_Name = '$GH_Name' WHERE GH_Code = $GH_Code";
        }

        if ($conn->query($sql) === TRUE) {
            if ($GH_Code == 0 || $GH_Code == '') {
                $lastInsertedGHCode = $conn->insert_id;
            } else {
                $lastInsertedGHCode = $GH_Code;
            }

            // ลบข้อมูลเดิมจากตาราง GroupPositionLine สำหรับ GH_Code ที่เป็นปัจจุบัน
            $sqlDelete = "DELETE FROM `GroupPositionLine` WHERE `GroupPositionLine`.`GH_Code` = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("s", $lastInsertedGHCode);
            $stmtDelete->execute();
            $stmtDelete->close();

            // เพิ่มข้อมูลใหม่ลงในตาราง GroupPositionLine
            $sqlInsert = "INSERT INTO `GroupPositionLine` (`GL_Code`, `GH_Code`, `PT_Code`, `GL_CreateDate`, `GL_ModifyDate`) VALUES (NULL, ?, ?, current_timestamp(), current_timestamp())";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("ss", $lastInsertedGHCode, $GL_CodeValue);
            for ($i = 0; $i < count($GL_Code); $i++) {
                $GL_CodeValue = $GL_Code[$i];
                $stmtInsert->execute();
            }
            $stmtInsert->close();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();

        // ส่งข้อความตอบกลับหรือเปลี่ยนเส้นทางไปหน้าอื่นตามต้องการ
        echo "<script> setTimeout(function() { window.location.href = `./{$_SESSION['PathPage']}`; }, 0); </script>";
    }
    ?>