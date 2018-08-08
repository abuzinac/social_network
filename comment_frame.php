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

?>

<script>
    function toggle() {
        var element = document.getElementById("comment_section");

        if (element.style.display === "block")
            element.style.display = "none";
        else
            element.style.display = "block";
    }
</script>

<?php

// Get id of post
if (isset($_GET ['post_id'])) {
    $post_id = $_GET['post_id'];
}

$user_query = mysqli_query($con, "SELECT added_by, user_to FROM post WHERE id='post_id'");
$row = mysqli_fetch_array($user_query);

$posted_to = $row['added_by'];

if (isset($_POST['postComment' . $post_id])) {
    $post_body = $_POST['post_body'];
    $post_body = mysqli_escape_string($con, $post_body);
    $date_time_now = $date("Y-m-d H:i:s"); // todo change date format
    $insert_post = mysqli_query($con, "INSERT INTO post_comment VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");
    echo "<p>Comment Posted! </p>";
}

?>

<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form"
      name="postComment <?php echo $post_id; ?>" method="post">
    <textarea name="post_body"></textarea>
    <input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
</form>

<!-- Load Comments -->

</body>
</html>