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

        <?php
        // Unread messages
        $messages = new Message($con, $userLoggedIn);
        $num_messages = $messages->getUnreadNumber();
        ?>

        <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name']; ?></a>
        <a href="index.php"><i class="fas fa-home fa-lg"></i></a>
        <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')"><i
                    class="fas fa-envelope fa-lg"></i></a>

        <?php
        if ($num_messages > 0)
            echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>'
        ?>

        <a href="#"><i class="far fa-bell fa-lg"></i></a>
        <a href="request.php"><i class="fas fa-users fa-lg"></i></a>
        <a href="#"><i class="fas fa-cog fa-lg"></i></a>
        <a href="includes/handlers/logout.php"><i class="fas fa-sign-out-alt fa-lg"></i></a>
    </nav>

    <div class="dropdown_data_window" style="height:0px; border: none;"></div>
    <input type="hidden" id="dropdown_data_type" value="">

</div>

<script>
    $(function () {

        var userLoggedIn = '<?php echo $userLoggedIn; ?>';
        var dropdownInProgress = false;

        $(".dropdown_data_window").scroll(function () {
            var bottomElement = $(".dropdown_data_window a").last();
            var noMoreData = $('.dropdown_data_window').find('.noMoreDropDownData').val();

            // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
            if (isElementInView(bottomElement[0]) && noMoreData === 'false') {
                loadPosts();
            }
        });

        function loadPosts() {
            if (dropdownInProgress) { //If it is already in the process of loading some posts, just return
                return;
            }

            dropdownInProgress = true;

            var page = $('.dropdown_data_window').find('.nextPageDropDownData').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'

            var pageName; //Holds name of page to send ajax request to
            var type = $('#dropdown_data_type').val();

            if (type === 'notification')
                pageName = "ajax_load_notifications.php";
            else if (type === 'message')
                pageName = "ajax_load_messages.php";

            $.ajax({
                url: "includes/handlers/" + pageName,
                type: "POST",
                data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                cache: false,

                success: function (response) {

                    $('.dropdown_data_window').find('.nextPageDropDownData').remove(); //Removes current .nextpage
                    $('.dropdown_data_window').find('.noMoreDropDownData').remove();

                    $('.dropdown_data_window').append(response);

                    dropdownInProgress = false;
                }
            });
        }

        //Check if the element is in view
        function isElementInView(el) {
            var rect = el.getBoundingClientRect();

            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
                rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
            );
        }
    });

</script>

<div class="wrapper">
