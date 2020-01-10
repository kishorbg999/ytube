<?php
require_once("includes/header.php");
require_once("includes/classes/account.php");
require_once("includes/classes/formSanitizer.php");
require_once("includes/classes/constants.php");
require_once("includes/classes/settingsFormProvider.php");

if(!User::isLoggedIn()){
    header("Location: login.php");
}

$detailsMessage = "";
$passwordMessage = "";
$formProvider = new SettingsFormProvider();

if(isset($_POST["saveDetails"])){
    $account = new Account($con);

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if($account->updateUserDetails($firstName, $lastName, $email, $userLoggedInObj->getUsername())){
        $detailsMessage = "<div class='alert alert-success'>
                                <strong>SUCESS!</strong> Details updated successfully
                            </div>";
    }else{
        $errorMessage = $account->getFirstError();

        if($errorMessage == ""){
            $errorMesage = "Something went wrong";
        }
        
        $detailsMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong> $errorMessage
                            </div>";
    }
}

if(isset($_POST["savePassword"])){
    $account = new Account($con);

    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

    if($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedInObj->getUsername())){
        $passwordMessage = "<div class='alert alert-success'>
                                <strong>SUCESS!</strong> Password updated successfully
                            </div>";
    }else{
        $errorMessage = $account->getFirstError();

        if($errorMessage == ""){
            $errorMesage = "Something went wrong";
        }
        
        $passwordMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong> $errorMessage
                            </div>";
    }
}
?>

<div class="settingsContainer column">

    <div class="formSection">
        <div class="message">
            <?php echo $detailsMessage ?>
        </div>
        <?php
            echo $formProvider->createUserDetailsForm(
                isset($_POST["firstName"]) ? $_POST["firstName"] : $userLoggedInObj->getFirstName(),
                isset($_POST["lastName"]) ? $_POST["lastName"] : $userLoggedInObj->getLastName(),
                isset($_POST["email"]) ? $_POST["email"] : $userLoggedInObj->getEmail()
            );
        ?>
    </div>

    <div class="formSection">
        <div class="message">
            <?php echo $passwordMessage ?>
        </div>
        
        <?php
            echo $formProvider->createPasswordForm();
        ?>
    </div>

</div>