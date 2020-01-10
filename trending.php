<?php
require_once("includes/header.php");
require_once("includes/classes/trendingProvider.php");

$trendingProvider = new TrendingProvider($con, $userLoggedInObj);
$videos = $trendingProvider->getVideos();

$videoGrid = new VideoGrid($con, $userLoggedInObj);
?>

<div class="largeVideoGridContainer">
    <?php
        if(sizeof($videos) > 0){
            echo $videoGrid->createLarge($videos, "Trending vidoes uploaded in last week", false);
        }else{
            echo "No trending videos to show";
        }
    ?>
</div>



<?php
require_once("includes/footer.php");
?>