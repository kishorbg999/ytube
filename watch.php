<?php
require_once("includes/header.php");
require_once("includes/classes/videoPlayer.php");
require_once("includes/classes/videoInfoSection.php");
require_once("includes/classes/commentSection.php");
require_once("includes/classes/comment.php");

if(!isset($_GET["id"])){
    echo "No url passed into this page";
    exit();       
}

$video = new Video($con, $_GET["id"], $userLoggedInObj);
$video->incrementViews();


?>
<script>
    $("#sideNavContainer").hide();
    $("#mainSectionContainer").toggleClass("leftPadding");
</script>
<script src="assets/js/videoPlayerAction.js"></script>

<div class="watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true);
    $videoInfoSection = new VideoInfoSection($con, $video, $userLoggedInObj);
    echo $videoInfoSection->create();
    $commentSection = new CommentSection($con, $video, $userLoggedInObj);
    echo $commentSection->create();
?>

</div>

<div class="suggestion">
    <?php
        $videoGrid = new VideoGrid($con, $userLoggedInObj);
        echo $videoGrid->create(null, null, false);
    ?>

</div>

<?php
require_once("includes/footer.php");
?>