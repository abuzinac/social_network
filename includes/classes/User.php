<?php

class User
{
    private $user;
    private $con;

    public function __construct($con, $user)
    {
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM user WHERE user_name='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    public function getUsername()
    {
        return $this->user['user_name'];
    }

    public function getNumPost()
    {
        $username = $this->user['user_name'];
        $query = mysqli_query($this->con, "SELECT num_post FROM user WHERE user_name='$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_post'];
    }

    public function getFirstAndLastName()
    {
        $username = $this->user['user_name'];
        $query = mysqli_query($this->con, "SELECT first_name, last_name FROM user WHERE user_name='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . " " . $row['last_name'];
    }

    public function isClosed()
    {
        $username = $this->user['user_name'];
        $query = mysqli_query($this->con, "SELECT user_closed FROM user WHERE user_name='$username'");
        $row = mysqli_fetch_array($query);

        if ($row['user_closed'] == 'yes')
            return true;
        else
            return false;
    }

    public function isFriend($username_to_check)
    {
        $usernameComma = "," . $username_to_check . ",";

        if (strstr($this->user['friend_array'], $usernameComma) || $username_to_check == $this->user['user_name']) {
            return true;
        } else
            return false;

    }

}