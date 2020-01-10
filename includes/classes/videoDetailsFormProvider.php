<?php

class VideoDetailsFormProvider {
    
    private $con;

    public function __construct($con){
        $this->con = $con;
    }

    public function createUploadForm(){
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput();
        $descriptionInput = $this->createDescriptionInput();
        $privacyInput = $this->createPrivacyInput();
        $categoryInput = $this->createCategoryInput();
        $uploadButton = $this->createSubmitbutton();
        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $privacyInput
                    $categoryInput
                    $uploadButton
                </form>";
    }

    public function createEditDetailsForm($video){
        $titleInput = $this->createTitleInput($video->getTitle());
        $descriptionInput = $this->createDescriptionInput($video->getDescription());
        $privacyInput = $this->createPrivacyInput($video->getPrivacy());
        $categoryInput = $this->createCategoryInput($video->getCategory());
        $saveButton = $this->createSavebutton();
        $videoId = $video->getId();
        $action = "action='editVideo.php?id=$videoId'";
        return "<form $action method='POST'>
                    $titleInput
                    $descriptionInput
                    $privacyInput
                    $categoryInput
                    $saveButton
                </form>";
    }

    private function createFileInput(){
        return "<div class='form-group'>
                    <input type='file' class='form-control-file' id='exampleFormControlFile1' name='fileInput' required />
                </div>";
    }

    private function createTitleInput($title = ""){
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Title' name='titleInput' value='$title' required />
                </div>";
    }

    private function createDescriptionInput($description = ""){
        return "<div class='form-group'>
                    <textarea class='form-control' row='3' placeholder='Description' name='descriptionInput'>$description</textarea>
                </div>";
    }

    private function createPrivacyInput($privacy = 0){
        
        $private = $privacy == 0 ? "selected" : "";
        $public = $privacy == 1? "selected" : "";

        return "<div class='form-group'>
                    <select class='form-control' name='privacyInput'>
                        <option value='0' $private>Private</option>
                        <option value='1' $public>Public</option>
                    </select>
                </div>";
    }

    private function createCategoryInput($category = ""){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();
        
        $html = "<div class='form-group'>
                    <select class='form-control' name='categoryInput'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $selected = ($category == $row["id"]) ? "selected" : ""; 
            $html = $html . "<option value=$row[id] $selected>$row[name]</option>";
        };
        
        $html = $html . "</select></div>";

        return $html;
    }

    private function createSubmitbutton(){
        return "<div class='form-group'>
                    <button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>
                </div>";
    }

    private function createSavebutton(){
        return "<div class='form-group'>
                    <button type='submit' class='btn btn-primary' name='saveButton'>Save</button>
                </div>";
    }

}

?>