<?php
    class SettingsFormProvider{
    
        public function createUserDetailsForm($firstName, $lastName, $email){
            $firstNameInput = $this->createFirstNameInput($firstName);
            $lastNameInput = $this->createLastNameInput($lastName);
            $emailInput = $this->createEmailInput($email);
            $saveButton = $this->createSaveUserDetailsButton();

            return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                        <span class='title'>User details</span>
                        $firstNameInput
                        $lastNameInput
                        $emailInput
                        $saveButton
                    </form>";
        }

        public function createPasswordForm(){
            $oldPassword = $this->createPasswordInput("oldPassword", "Old password");
            $newPassword = $this->createPasswordInput("newPassword", "New Password");
            $newPassword2 = $this->createPasswordInput("newPassword2", "Confirm new password");
            $saveButton = $this->createSavePasswordButton();

            return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                        <span class='title'>User details</span>
                        $oldPassword
                        $newPassword
                        $newPassword2
                        $saveButton
                    </form>";
        }

        public function createPasswordInput($name, $placeholder){
            
            return "<div class='form-group'>
                        <input class='form-control' type='password' placeholder='$placeholder' name='$name' required />
                    </div>";
        }

        private function createSavePasswordButton(){
            return "<button type='submit' class='btn btn-primary' name='savePassword'>Save</button>";
        }
    
        private function createFirstNameInput($value){
            if($value == null){
                $value = "";
            }
            
            return "<div class='form-group'>
                        <input class='form-control' type='text' placeholder='First name' name='firstName' value='$value' required />
                    </div>";
        }

        private function createLastNameInput($value){
            if($value == null){
                $value = "";
            }
            
            return "<div class='form-group'>
                        <input class='form-control' type='text' placeholder='Last name' name='lastName' value='$value' required />
                    </div>";
        }

        private function createEmailInput($value){
            if($value == null){
                $value = "";
            }
            
            return "<div class='form-group'>
                        <input class='form-control' type='email' placeholder='Email' name='email' value='$value' required />
                    </div>";
        }
    
        private function createSaveUserDetailsButton(){
            return "<button type='submit' class='btn btn-primary' name='saveDetails'>Save</button>";
        }
    }
?>