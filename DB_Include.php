<?PHP
if (!session_id()) session_start();
$_SESSION["ip"] = "10.10.9.65";
$currentUser = isset($_SESSION['User']) ? $_SESSION['User'] : '';

//------------------------------------------
$servername="localhost";
$username="root";
$password="";
$dbname="newsandactivities";
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คว่าเชื่อมต่อฐานข้อมูลสำเร็จหรือไม่
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตั้งค่าภาษาให้เป็น utf8  
// $conn->set_charset("utf8");
// ตั้งค่าภาษาให้เป็น utf8mb4 เพื่ิอลองรับ Emoji เปลี่ยนตารางกับฟิวเป็น utf8mb4_general_ci	  
$conn->set_charset("utf8mb4"); 
?>