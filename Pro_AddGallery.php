<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>GUNKUL Engineering (GUNKUL)</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <?php
  // Check if any files are selected
  if (!empty($_FILES['ImageGallery']['name'])) {
    Process each selected file
    foreach ($_FILES['ImageGallery']['name'] as $key => $name) {
      $fileTmpName = $_FILES['ImageGallery']['tmp_name'][$key];
      $fileType = $_FILES['ImageGallery']['type'][$key];
      $fileSize = $_FILES['ImageGallery']['size'][$key];
      $fileError = $_FILES['ImageGallery']['error'][$key];
      
      // Handle the file upload process here (e.g., move_uploaded_file)
      // You can access the file using $fileTmpName and perform necessary operations
      
      // Example: Move the uploaded file to a destination directory
      $uploadDir = 'img/UploadAddGallery/';
      $destination = $uploadDir . $name;
      move_uploaded_file($fileTmpName, $destination);
      
      // You can perform additional processing or save file information to a database
      
      echo "File $name uploaded successfully.<br>";
    }
  } else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    echo "No files selected for upload.";
  }
?>
</head>
</html>