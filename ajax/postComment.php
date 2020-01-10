<?php
require_once("../includes/config.php");
require_once("../includes/classes/user.php");
require_once("../includes/classes/comment.php");

if(isset($_POST["commentText"]) && isset($_POST["postedBy"]) && isset($_POST["videoId"])){
    
    $userLoggedInObj = new User($con, $_SESSION["userLoggedIn"]);
    $query = $con->prepare("INSERT INTO comments(postedBy, videoId, responseTo, body) 
                            VALUES(:postedBy, :videoId, :responseTo, :body)");
    $query->bindParam(":postedBy", $postedBy);
    $query->bindParam(":videoId", $videoId);
    $query->bindParam(":responseTo", $responseTo);
    $query->bindParam(":body", $body);

    $postedBy = $_POST["postedBy"];
    $videoId = $_POST["videoId"];
    $body = $_POST["commentText"];
    $responseTo = $_POST["responseTo"];

    $query->execute();

    $newComment = new Comment($con, $con->lastInsertId(), $userLoggedInObj, $videoId);

    echo $newComment->create();
    
}else{
    echo "One or more parameters are not passed";
}