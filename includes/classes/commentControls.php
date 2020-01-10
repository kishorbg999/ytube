<?php

require_once("buttonProvider.php");

class CommentControls{
    private $con, $comment, $userLoggedInObj;

    public function __construct($con, $comment, $userLoggedInObj){
        $this->con = $con;
        $this->comment = $comment;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create(){
        
        $replyButton = $this->createReplyButton();
        $likesCount = $this->createLikesCount();
        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();
        $replySection = $this->createReplySection();

        return "<div class='controls'>
                    $replyButton
                    $likesCount
                    $likeButton
                    $dislikeButton
                </div>
                $replySection";

    }

    private function createReplyButton(){
        $text = "REPLY";
        $action = "toggleReply(this)";

        return ButtonProvider::createButton($text, null, $action, null);
    }

    private function createLikesCount(){
        $text = $this->comment->getLikes();

        if($text == 0){
            $text = "";
        }

        return "<span class='likesCount'>$text</span>";
    }

    private function createReplySection(){
        $postedBy = $this->userLoggedInObj->getUsername();
        $videoId = $this->comment->getVideoId();
        $commentId = $this->comment->getId();

        $profileButton = ButtonProvider::createUserProfileButton($this->con, $postedBy);

        $cancelAction = "toggleReply(this)";
        $cancelButton = ButtonProvider::createButton("Cancel", null, $cancelAction, "cancelComment");

        $postAction = "postComment(this, \"$postedBy\", $videoId, $commentId, \"repliesSection\")";
        $postButton = ButtonProvider::createButton("Comment", null, $postAction, "postComment");

        return "<div class='commentForm hidden'>
                    $profileButton
                    <textarea class='commentBodyClass' placeholder='Add Comment'></textarea>
                    $cancelButton
                    $postButton
                </div>";
    }

    private function createLikeButton(){
        
        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "likeComment($commentId, this, $videoId)";
        $class = "likeButton";
        $imageSrc = ($this->comment->wasLikedBy()) ? "assets/images/icons/thumb-up-active.png" : "assets/images/icons/thumb-up.png";

        return ButtonProvider::createButton("", $imageSrc, $action, $class);
    }

    private function createDislikeButton(){
        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "dislikeComment($commentId, this, $videoId)";
        $class = "dislikeButton";
        $imageSrc = ($this->comment->wasDislikedBy()) ? "assets/images/icons/thumb-down-active.png" : "assets/images/icons/thumb-down.png";

        return ButtonProvider::createButton("", $imageSrc, $action, $class);
    }
}