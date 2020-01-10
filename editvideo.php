<?php
require_once("includes/header.php");
require_once("includes/classes/videoPlayer.php");
require_once("includes/classes/videoDetailsFormProvider.php");
require_once("includes/classes/videoUploadData.php");
require_once("includes/classes/selectThumbnail.php");

if(!User::isLoggedIn()){
    header("Location: signin.php");
}

if(!isset($_GET["id"])){
    echo "No video selected";
    exit();
}

$video = new Video($con, $_GET["id"], $userLoggedInObj);

if($video->getUploadedBy() != $userLoggedInObj->getUsername()){
    echo "Not your video";
    exit();
}

$detailsMessage = "";

if(isset($_POST["saveButton"])){
    $videoData = new VideoUploadData(
        null,
        $_POST["titleInput"],
        $_POST["descriptionInput"],
        $_POST["privacyInput"],
        $_POST["categoryInput"],
        $userLoggedInObj->getUsername()
    );

    if($videoData->updateDetails($con, $video->getId())){
        $detailsMessage = "<div class='alert alert-success'>
                                <strong>SUCESS!</strong> Details updated successfully
                            </div>";
    }else{
        $detailsMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong> Something went wrong.
                            </div>";
    }
}
$video = new Video($con, $_GET["id"], $userLoggedInObj);

?>
<script src="assets/js/editVideoAction.js"></script>
<div class="editVideoContainer column">

    <div class="message">
        <?php echo $detailsMessage; ?>
    </div>

    <div class="topSection">
        <?php 
            $videoPlayer = new VideoPlayer($video);
            echo $videoPlayer->create(false);

            $selectThumbnail = new SelectThumbnail($con, $video);
            echo $selectThumbnail->create();
        ?>
    </div>
    <div class="bottomSection">
        <?php  
            $formProvider = new videoDetailsFormProvider($con);
            echo $formProvider->createEditDetailsForm($video);
        ?>
    </div>
</div>
<?php
require_once("includes/footer.php");
?>