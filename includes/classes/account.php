<?php

require_once("constants.php");

class Account {
    
    private $con;
    private $errors = array();

    public function __construct($con){
        $this->con = $con;
    }

    public function register($firstName, $lastName, $username, $email, $email2, $password, $password2){
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUsername($username);
        $this->validateEmails($email, $email2);
        $this->validatePassword($password, $password2);

        if(empty($this->errors)){
            return $this->insertUserDetails($firstName, $lastName, $username, $email, $password);
        }else{
            return false;
        }
    }

    public function updateUserDetails($firstName, $lastName, $email, $username){
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateNewEmail($email, $username);

        if(empty($this->errors)){
            $query = $this->con->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, email=:email WHERE username=:username");
            $query->bindParam(":firstName", $firstName);
            $query->bindParam(":lastName", $lastName);
            $query->bindParam(":email", $email);
            $query->bindParam(":username", $username);
            $query->execute();

            return $query->execute();;
        }else{
            return false;
        }

    }

    public function updatePassword($oldPassword, $newPassword, $newPassword2, $username){
        $this->validateOldPassword($oldPassword, $username);
        $this->validatePassword($newPassword, $newPassword2);

        if(empty($this->errors)){
            $query = $this->con->prepare("UPDATE users SET password=:password WHERE username=:username");
            $query->bindParam(":password", $newPassword);
            $query->bindParam(":username", $username);

            $newPassword = hash("sha256", $newPassword);
            $query->execute();

            return $query->execute();;
        }else{
            return false;
        }

    }

    public function login($username, $password){
        $password = hash("sha256", $password);

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:username AND password=:password");

        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);

        $query->execute();

        if($query->rowCount() == 1){
            return true;
        }else{
            array_push($this->errors, Constants::$invalidCredentials);
            return false;
        }
    }

    public function insertUserDetails($firstName, $lastName, $username, $email, $password){
        
        $password = hash("sha256", $password);

        $profilePic = "assets/images/profilePictures/default.png";

        $query = $this->con->prepare("INSERT INTO users(firstName, lastName, username, email, password, profilePic) 
                                    VALUES(:firstName, :lastName, :username, :email, :password, :profilePic)");

        $query->bindParam(":firstName", $firstName);
        $query->bindParam(":lastName", $lastName);
        $query->bindParam(":username", $username);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);
        $query->bindParam(":profilePic", $profilePic);

        return $query->execute();

    }

    private function validateFirstName($firstName){
        if(strlen($firstName) > 25 || strlen($firstName) < 2){
            array_push($this->errors, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($lastName){
        if(strlen($lastName) > 25 || strlen($lastName) <2){
            array_push($this->errors, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($username){
        if(strlen($username) > 25 || strlen($username) <2){
            array_push($this->errors, Constants::$usernameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT username FROM users WHERE username=:un");

        $query->bindParam(":un", $username);
        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errors, Constants::$usernameTaken);
        }
    }

    private function validateEmails($email, $email2){
        if($email != $email2){
            array_push($this->errors, Constants::$emailNotMatching);
            return;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($this->errors, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:email");

        $query->bindParam(":email", $email);
        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errors, Constants::$emailTaken);
        }
    }

    private function validateNewEmail($email, $username){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($this->errors, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:email AND username!=:username");

        $query->bindParam(":email", $email);
        $query->bindParam(":username", $username);
        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errors, Constants::$emailTaken);
        }
    }

    private function validatePassword($password, $password2){
        if($password != $password2){
            array_push($this->errors, Constants::$passwordNotMatching);
            return;
        }

        if(preg_match("/[^A-Za-z0-9]/", $password)){
            array_push($this->errors, Constants::$passwordPattern);
            return;
        }

        if(strlen($password) > 30 || strlen($password) <5){
            array_push($this->errors, Constants::$passwordCharacters);
            return;
        }

    }

    private function validateOldPassword($oldPassword, $username){
        $oldPassword = hash("sha256", $oldPassword);
        
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $oldPassword);

        $query->execute();

        if($query->rowCount() > 0){
            return;
        }else{
            array_push($this->errors, Constants::$currentPasswordNotMatch);
        }
    }

    public function getError($error){
        if(in_array($error, $this->errors)){
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError(){
        if(!empty($this->errors)){
            return $this->errors[0];
        }else{
            return "";
        }
    }
}

?>