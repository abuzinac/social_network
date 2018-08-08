<?php
//Declaring variables to prevent errors
$fname = ""; //First name
$lname = ""; //Last name
$em = ""; //Email
$em2 = ""; //Email 2
$password = ""; //Password
$password2 = ""; //Password 2
$date = ""; //Sign up date
$error_array = array(); //Holds error message

if (isset($_POST['register_button'])) {

//Registration form value

//First name
    $fname = strip_tags($_POST['reg_fname']); //Remove HTML tags
    $fname = str_replace(' ', '', $fname); //Remove spaces
    $fname = ucfirst(strtolower($fname)); //Uppercase first letter
    $_SESSION['reg_fname'] = $fname; //Stores first name into session variable
//Last name
    $lname = strip_tags($_POST['reg_lname']); //Remove HTML tags
    $lname = str_replace(' ', '', $lname); //Remove spaces
    $lname = ucfirst(strtolower($lname)); //Uppercase first letter
    $_SESSION['reg_lname'] = $lname; //Stores last name into session variable


//Email
    $em = strip_tags($_POST['reg_email']); //Remove HTML tags
    $em = str_replace(' ', '', $em); //Remove spaces
    $_SESSION['reg_email'] = $em; //Stores email into session variable


//Email 2
    $em2 = strip_tags($_POST['reg_email2']); //Remove HTML tags
    $em2 = str_replace(' ', '', $em2); //Remove spaces
    $_SESSION['reg_email2'] = $em2; //Stores email 2 into session variable


//Password
    $password = strip_tags($_POST['reg_password']); //Remove HTML tags
    $password2 = strip_tags($_POST['reg_password2']); //Remove HTML tags


//Sign up date
    $date = date("Y-m-d"); //Current Date

    if ($em == $em2) {
//Check if email is in valid format

        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {

            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

//Check if email already exists
            $e_check = mysqli_query($con, "SELECT email FROM user WHERE email='$em'");

//Count number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if ($num_rows > 0) {
                array_push($error_array, "Email already in use<br>"); //todo display email from database
            }

        } else {
            array_push($error_array, "Invalid format<br>");
        }

    } else {
        array_push($error_array, "Emails don't match<br>");
    }

    if (strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }

    if (strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }

    if ($password != $password2) {
        array_push($error_array, "Your password do not match<br>");
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain valid english characters or numbers<br>");
        }
    }

    if (strlen($password) > 30 || strlen($password) < 5) {
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }

    if (empty($error_array)) {
        $password = md5($password); //Encrypt password before sending to database

//Generate username by concatenating first name and last name
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT user_name FROM user WHERE user_name='$username'");

        $i = 0;
//if username exists add number to username
        while (mysqli_num_rows($check_username_query) != 0) {
            $i++; //add 1 to i
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT user_name FROM user WHERE user_name='$username'");
        }

//Profile picture assignment
//todo make switch statement for all default pics
        $rand = rand(1, 2); //Random number between 1 and 2
        if ($rand == 1)
            $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
        else if ($rand == 2)
            $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";

//Insert values in database
        $query = mysqli_query($con, "INSERT INTO user VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date',
'$profile_pic', '0', '0', 'no', ',')");

        array_push($error_array, "<span style='color: #14C800;' >You're all set! Go ahead and login!</span><br>");

//Clear session variables
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";

    }


}