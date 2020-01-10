<?php 
require_once("includes/header.php");
require_once("includes/classes/videoUploadData.php");
require_once("includes/classes/videoProcessor.php");

if(!isset($_POST["uploadButton"])){
    echo implode(" ", array_keys($_POST));
    echo implode(" ", $_POST);
    
    echo "No file sent to page";
    exit();
}

$videoUploadData = new VideoUploadData(
                        $_FILES["fileInput"],
                        $_POST["titleInput"],
                        $_POST["descriptionInput"],
                        $_POST["privacyInput"],
                        $_POST["categoryInput"],
                        $userLoggedInObj->getUsername());

$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);


if($wasSuccessful){
    echo "Upload Successful";
}
?>
