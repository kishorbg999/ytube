<?php
require_once("../includes/config.php");
require_once("../includes/classes/comment.php");
require_once("../includes/classes/user.php");

$username = $_SESSION["userLoggedIn"];
$commentId = $_POST["commentId"];
$videoId = $_POST["videoId"];

$userLoggedInObj = new User($con, $username);
$commentObj = new Comment($con, $commentId, $userLoggedInObj, $videoId);

echo $commentObj->dislike();

?>