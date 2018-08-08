<?php

class Post
{
    private $user_obj;
    private $con;

    public function __construct($con, $user)
    {
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }

    public function submitPost($body, $user_to)
    {
        $body = strip_tags($body); // Removes html tags
        $body = mysqli_real_escape_string($this->con, $body);
        $check_empty = preg_replace('/\s+/', '', $body); // Delete all spaces

        if ($check_empty != "") {

            // Current date and time
            $date_added = date("Y-m-d H:i:s");

            // Get username
            $added_by = $this->user_obj->getUsername();

            // if user is on own profile, user_to is 'none'
            if ($user_to == $added_by) {
                $user_to = "none";
            }

            // Insert posts to database
            $query = mysqli_query($this->con, "INSERT INTO post VALUES('', '$body', '$added_by', '$user_to',
                                                    '$date_added', 'no', 'no', '0')");
            $returned_id = mysqli_insert_id($this->con);

            // Insert notification


            // Update post count for user
            $num_posts = $this->user_obj->getNumPost();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE user SET num_post='$num_posts' WHERE user_name='$added_by'");

        }
    }

    /**
     * @param $data
     * @param $limit
     */
    public function loadPostsFriends($data, $limit)
    {
        $page = $data['page'];
        $userLoggedIn = $this->user_obj->getUsername();

        if ($page == 1)
            $start = 0;
        else
            $start = ($page - 1) * $limit;

        $str = ""; // String to return
        $data_query = mysqli_query($this->con, "SELECT * FROM post WHERE deleted='no' ORDER BY id DESC ");

        if (mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; // Number of results checks (not necessarily posted)
            $count = 1;


            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $body = $row['body'];
                $added_by = $row['added_by'];
                $date_time = $row['date_added'];

                // Prepare user_to string so it can be included even if not posted to a user
                if ($row['user_to' == 'none']) {
                    $user_to = "";
                } else {
                    $user_to_obj = new User($this->con, $row['user_to']);
                    $user_to_name = $user_to_obj->getFirstAndLastName();
                    $user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
                }

                //Check if user who posted, have their account closed
                $added_by_obj = new User($this->con, $added_by);
                if ($added_by_obj->isClosed()) {
                    continue;
                }

                // Check user friend array and return posts
                $user_logged_obj = new User($this->con, $userLoggedIn);
                if ($user_logged_obj->isFriend($added_by)) {


                    if ($num_iterations++ < $start)
                        continue;

                    // Once 10 posts have been loaded, break
                    if ($count > $limit) {
                        break;
                    } else {
                        $count++;
                    }

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM user
                                              WHERE user_name='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];


                    //Time frame
                    $date_time_now = date("Y-m-d H:i:s"); //todo change date format
                    $start_date = new Datetime($date_time);  // time of post
                    $end_date = new DateTime($date_time_now);// current time
                    $interval = $start_date->diff($end_date);// differences between dates
                    if ($interval->y >= 1) {
                        if ($interval == 1)
                            $time_message = $interval->y . " year ago"; // 1 year ago
                        else
                            $time_message = $interval->y . " years ago"; // 1+ year ago
                    } elseif ($interval->m >= 1) {
                        if ($interval->d == 0) {
                            $days = " ago";
                        } elseif ($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        } else {
                            $days = $interval->d . " days ago";
                        }

                        if ($interval->m == 1) {
                            $time_message = $interval->m . " month" . $days;
                        } else {
                            $time_message = $interval->m . " months" . $days;
                        }
                    } elseif ($interval->d >= 1) {
                        if ($interval->d == 1) {
                            $time_message = "Yesterday";
                        } else {
                            $time_message = $interval->d . " days ago";
                        }
                    } elseif ($interval->h >= 1) {
                        if ($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        } else {
                            $time_message = $interval->h . " hours ago";
                        }
                    } elseif ($interval->i >= 1) {
                        if ($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        } else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    } else {
                        if ($interval->s < 30) {
                            $time_message = "Just now";
                        } else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }
                    $str .= "<div class ='status_post' xmlns=\"http://www.w3.org/1999/html\">
                        <div class='post_profile_pic'>
                            <img src='$profile_pic' width='50' alt='profile pic'>
                        </div>
                        <div class='post_by' style='color: #ACACAC'>
                            <a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;
                            $time_message
                        </div>
                        <div id='post_body'>
                            $body
                            <br>
                        </div>
                        
                     </div>
                     <hr>";
                }
            } // End while loop

            if ($count > $limit)
                $str .= "<input type='hidden' class='nextPage' value = '" . ($page + 1) . "'>
                         <input type= 'hidden' class= 'noMorePosts' value='false'>";
            else
                $str .= "<input type= 'hidden' class= 'noMorePosts' value='true'><p style='text-align: center'>No more posts to show!</p>";


        }

        echo $str;

    }
}