<?php

//todo we can change in to include
require "config/config.php";

include "includes/classes/User.php";
include "includes/classes/Post.php";
include "includes/classes/Message.php";


if (isset($_SESSION['user_name'])) {
    $userLoggedIn = $_SESSION['user_name'];

    // show username on top bar
    $user_details_query = mysqli_query($con, "SELECT * FROM user WHERE user_name='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
} else {
    header("Location: register.php");
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>connect</title>

    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <script src="assets/js/connect.js"></script>
    <script src="assets/js/jquery.jcrop.js"></script>
    <script src="assets/js/jcrop_bits.js"></script>

    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css"/>
</head>

<body>

<div class="top_bar">

    <div class="logo">
        <a href="index.php">connect</a>
    </div>

    <nav>
        <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name']; ?></a>
        <a href="index.php"><i class="fas fa-home fa-lg"></i></a>
        <a href="javascript:void(0)" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')"><i
                    class="fas fa-envelope fa-lg"></i></a>
        <a href="#"><i class="far fa-bell fa-lg"></i></a>
        <a href="request.php"><i class="fas fa-users fa-lg"></i></a>
        <a href="#"><i class="fas fa-cog fa-lg"></i></a>
        <a href="includes/handlers/logout.php"><i class="fas fa-sign-out-alt fa-lg"></i></a>
    </nav>

    <div class="dropdown_data_window"></div>
    <input type="hidden" id="dropdown_data_type" value="">

</div>

<div class="wrapper">
