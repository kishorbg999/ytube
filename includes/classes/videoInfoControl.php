<?php

require_once("includes/classes/buttonProvider.php");

class VideoInfoControl {
    
    private $video, $userLoggedInObj;

    public function __construct($video, $userLoggedInObj){
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create(){
        
        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();

        return "<div class='controls'>
                    $likeButton
                    $dislikeButton
                </div>";

    }

    private function createLikeButton(){
        
        $text = $this->video->getLikes();
        $videoId = $this->video->getId();
        $action = "likeVideo(this, $videoId)";
        $class = "likeButton";
        $imageSrc = ($this->video->wasLikedBy()) ? "assets/images/icons/thumb-up-active.png" : "assets/images/icons/thumb-up.png";

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }

    private function createDislikeButton(){
        $text = $this->video->getDislikes();
        $videoId = $this->video->getId();
        $action = "dislikeVideo(this, $videoId)";
        $class = "dislikeButton";
        $imageSrc = ($this->video->wasDislikedBy()) ? "assets/images/icons/thumb-down-active.png" : "assets/images/icons/thumb-down.png";

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }
    
}

?>