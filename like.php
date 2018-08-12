<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php

//todo we can change in to include
require "config/config.php";
include "includes/classes/User.php";
include "includes/classes/Post.php";

if (isset($_SESSION['user_name'])) {
    $userLoggedIn = $_SESSION['user_name'];

    // show username on top bar
    $user_details_query = mysqli_query($con, "SELECT * FROM user WHERE user_name='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
} else {
    header("Location: register.php");
}

// Get id of post
if (isset($_GET ['post_id'])) {
    $post_id = $_GET['post_id'];
}

$get_likes = mysqli_query($con, "SELECT likes, added_by FROM post WHERE id='$post_id'");
$row = mysqli_fetch_array($get_likes);
$total_likes = $row['likes'];
$user_liked = $row['added_by'];

$user_details_query = mysqli_query($con, "SELECT * FROM user WHERE user_name='$user_liked'");
$row = mysqli_fetch_array($user_details_query);

// Like button

// Unlike button

// Check for previous likes
$check_query = mysqli_query($con, "SELECT * FROM likes WHERE user_name='$userLoggedIn' AND post_id='$post_id'");
$num_rows = mysqli_num_rows($check_query);

if ($num_rows > 0) {
    echo '';
} else {
    echo '';
}

?>

</body>
</html>

