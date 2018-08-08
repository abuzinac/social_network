<?php

//todo we can change in to include
require "config/config.php";
require "includes/form_handlers/register_handler.php";
require "includes/form_handlers/login_handler.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connect to connect!</title>
    <link rel="stylesheet" href="assets/css/register_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>

<?php

if (isset($_POST['register_button'])) {
    echo '
    <script>
    $(document).ready(function() {
      $("#first").hide();
      $("#second").show();
    });
    </script>
    ';
}

?>

<div class="wrapper">

    <div class="login_box">

        <div class="login_header">
            <h1>connect</h1>
            <p>Login or sign up bellow!</p>
        </div>

        <!--Login form-->
        <div id="first">
            <form action="register.php" method="post">
                <input type="email" name="log_email" placeholder="Email Address"
                       value="<?php
                       if (isset($_SESSION["log_email"])) {
                           echo $_SESSION["log_email"];
                       }
                       ?>" required>
                <br>

                <input type="password" name="log_password" placeholder="Password">
                <br>

                <?php if (in_array("Email or password was incorrect<br>", $error_array))
                    echo "Email or password was incorrect<br>"; ?>

                <input type="submit" name="login_button" value="Login">

                <br>
                <a href="#" id="signup" class="signup">Need a account? Register here!</a>


            </form>
        </div>

        <!--Register form-->
        <div id="second">
            <form action="register.php" method="post">
                <input type="text" name="reg_fname" placeholder="First name" value="<?php
                if (isset($_SESSION["reg_fname"])) {
                    echo $_SESSION["reg_fname"];
                }
                ?>" required>
                <br>

                <?php if (in_array("Your first name must be between 2 and 25 characters<br>", $error_array))
                    echo "Your first name must be between 2 and 25 characters<br>"; ?>

                <input type="text" name="reg_lname" placeholder="Last name" value="<?php
                if (isset($_SESSION["reg_lname"])) {
                    echo $_SESSION["reg_lname"];
                }
                ?>" required>
                <br>

                <?php if (in_array("Your last name must be between 2 and 25 characters<br>", $error_array))
                    echo "Your last name must be between 2 and 25 characters<br>"; ?>

                <input type="email" name="reg_email" placeholder="Email" value="<?php
                if (isset($_SESSION["reg_email"])) { //todo if email is already in use restore session for email
                    echo $_SESSION["reg_email"];
                }
                ?>" required>
                <br>

                <input type="email" name="reg_email2" placeholder="Confirm email" value="<?php
                if (isset($_SESSION["reg_email2"])) { //todo if email is already in use restore session for email
                    echo $_SESSION["reg_email2"];
                }
                ?>" required>
                <br>

                <?php
                if (in_array("Email already in use<br>", $error_array))
                    echo "Email already in use<br>";
                else if (in_array("Invalid format<br>", $error_array))
                    echo "Invalid format<br>";
                else if (in_array("Emails don't match<br>", $error_array))
                    echo "Emails don't match<br>";
                ?>

                <input type="password" name="reg_password" placeholder="Password" required>
                <br>
                <input type="password" name="reg_password2" placeholder="Confirm password" required>
                <br>

                <?php
                if (in_array("Your password must be between 5 and 30 characters<br>", $error_array))
                    echo "Your password must be between 5 and 30 characters<br>";
                else if (in_array("Your password can only contain valid english characters or numbers<br>", $error_array))
                    echo "Your password can only contain valid english characters or numbers<br>";
                else if (in_array("Your password do not match<br>", $error_array))
                    echo "Your password do not match<br>";
                ?>

                <input type="submit" name="register_button" value="Register">
                <br>

                <?php
                if (in_array("<span style='color: #14C800;' >You're all set! Go ahead and login!</span><br>", $error_array))
                    echo "<span style='color: #14C800;' >You're all set! Go ahead and login!</span><br>";
                ?>
                <br>

                <a href="#" id="signin" class="signin">Already have a account? Sign up here!</a>


            </form>
        </div>

    </div>

</div>

</body>
</html>

