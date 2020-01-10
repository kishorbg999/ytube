<?php

class SubscriptionsProvider{

    private $con, $userLoggedinObj;

    public function __construct($con, $userLoggedinObj){
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedinObj;
    }

    public function getVideos(){
        $videos = array();

        $subscriptions = $this->userLoggedInObj->getSubscriptions();

        if(sizeOf($subscriptions) > 0){
            
            $condition = "";
            $i = 0;

            while($i < sizeof($subscriptions)){
                if($i == 0){
                    $condition .= "WHERE uploadedBy=?";
                }else{
                    $condition .= " OR uploadedBy=?";
                }
                $i++;
            }

            $videoSql = "SELECT * FROM videos $condition ORDER BY uploadedDate DESC";

            $videoQuery = $this->con->prepare($videoSql);

            $i=1;

            foreach($subscriptions as $sub){
                $username = $sub->getUsername();
                $videoQuery->bindValue($i, $username);
                $i++;
            }

            $videoQuery->execute();
            while($row = $videoQuery->fetch(PDO::FETCH_ASSOC)){
                $video = new Video($this->con, $row, $this->userLoggedInObj);
                array_push($videos, $video);
            }

            return $videos;

        }

        return $videos;
    }

}

?>