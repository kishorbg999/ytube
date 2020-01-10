<?php 

require_once("includes/config.php"); 
require_once("includes/classes/formSanitizer.php");
require_once("includes/classes/account.php");
require_once("includes/classes/constants.php");

$account = new Account($con);

function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

if(isset($_POST["submitButton"])){
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);

    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);

    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

    $wasSuccessful = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

    if($wasSuccessful){
        $_SESSION["userLoggedIn"] = $username;
        header("Location: index.php");
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Youtube Clone</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="signInContainer">
            <div class="column">
                <div class="header">
                    <img src="assets/images/icons/youtube.png" />
                    <h3>Sign up</h3>
                    <span>to continue to youtube.</span>
                </div>
                <div class="loginForm">
                    <form action="signup.php" method="POST">
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                        <input type="text" name="firstName" placeholder="First Name" autocomplete="off" value="<?php getInputValue("firstName") ?>" required />
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                        <input type="text" name="lastName" placeholder="Last Name" autocomplete="off" value="<?php getInputValue("lastName") ?>" required />
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <input type="text" name="username" placeholder="Username" autocomplete="off" value="<?php getInputValue("username") ?>" required />
                        
                        <?php echo $account->getError(Constants::$emailNotMatching); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <input type="email" name="email" placeholder="Email" autocomplete="off" value="<?php getInputValue("email") ?>" required />
                        <input type="email" name="email2" placeholder="Confirm Email" autocomplete="off" value="<?php getInputValue("email2") ?>" required />

                        <?php echo $account->getError(Constants::$passwordNotMatching); ?>
                        <?php echo $account->getError(Constants::$passwordPattern); ?>
                        <?php echo $account->getError(Constants::$passwordCharacters); ?>
                        <input type="password" name="password" placeholder="Password" autocomplete="off" required />
                        <input type="password" name="password2" placeholder="Confirm Password" autocomplete="off" required />

                        <input type="submit" name="submitButton" value="SUBMIT" />
                    </form> 
                </div>
                <a class="signInMessage" href="signin.php">Already have account?</a>
            </div>
        </div>
    </body>
</html>
