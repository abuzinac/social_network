<?php
include("../../config/config.php");
include("../classes/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];

$names = explode(" ", $query);

// check for predict what we searching
if (strpos($query, "_") !== false) {
    $userReturned = mysqli_query($con, "SELECT * FROM user WHERE user_name LIKE '$query%' AND user_closed='no' LIMIT 8");
} elseif (count($names) == 2) {
    $userReturned = mysqli_query($con, "SELECT * FROM user WHERE (first_name LIKE '%$names[0]%' AND last_name LIKE '%$names[1]%') AND user_closed='no' LIMIT 8");
} else {
    $userReturned = mysqli_query($con, "SELECT * FROM user WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='no' LIMIT 8");
}

if ($query != "") {
    while ($row = mysqli_fetch_array($userReturned)) {

        $user = new User($con, $userLoggedIn);

        if ($row['user_name'] != $userLoggedIn) {
            $mutual_friends = $user->getMutualFriends($row['user_name']) . " friends in common";
        } else {
            $mutual_friends = "";
        }

        if ($user->isFriend($row['user_name'])) {
            echo "<div class='resultDisplay' xmlns=\"http://www.w3.org/1999/html\">
                    <a href='messages.php?u=" . $row['user_name'] . "' style='color: #000'>
                        <div class='liveSearchProfilePic'>
                            <img src='" . $row['profile_pic'] . "'>
                        </div>
                        
                        <div class='liveSearchText'>
                            " . $row['first_name'] . " " . $row['last_name'] . "
                            <p  style='margin: 0'>" . $row['user_name'] . "</p>
                            <p id='grey'>" . $mutual_friends . "</p>
                        </div>
                    </a>
                </div > ";
        }

    }
}