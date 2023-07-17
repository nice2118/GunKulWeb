<?php
include("DB_Include.php");
if(count($_FILES["file"]["name"]) > 0)
{
 //$output = '';
//  sleep(3);
 for($count=0; $count<count($_FILES["file"]["name"]); $count++)
 {
  $file_name = $_FILES["file"]["name"][$count];
  $tmp_name = $_FILES["file"]['tmp_name'][$count];
  $file_array = explode(".", $file_name);
  $file_extension = end($file_array);

  $location = 'img/UploadAddGallery/' . $file_name;
  if(move_uploaded_file($tmp_name, $location))
  {
    echo 'AAAA';
//    $query = "
//    INSERT INTO tbl_image (image_name, image_description) 
//    VALUES ('".$file_name."', '')
//    ";
//    $statement = $conn->prepare($query);
//    $statement->execute();
  }else{
    echo 'BBBB';
  }
 }
}
?>

