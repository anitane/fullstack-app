<?php

include('database_connection.php');

$pieces = explode(",", $_COOKIE["user_id"]);
$user_name = $pieces[0];
$user_id = $pieces[1];

if($_POST['action'] == 'fetch_user')
{
    $query = "
  SELECT users.id,users.name, groups.name as group_name, users.followers_count FROM users INNER JOIN groups ON users.group_id=groups.id  GROUP BY users.name";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';
    foreach($result as $row)
    {
        $output .= '
   <div class="row">
    <div class="col-md-8">
     <h4><b>'.$row["name"].'    ,   '.$row["group_name"].'  ('.$row["followers_count"].')';
        // don't show follow/unfollow button for logged user
        if ($row["name"] != $user_name){
            $output .= '    '.make_follow_button($connect, $row["id"], $user_id).'';
        }
        $output .= '</b></h4>
    </div>
   </div>
   <hr />';
    }
    echo $output;
}

if( $_POST['action'] == 'follow')
{
    $query = "
  INSERT INTO followers
  (user_id_following, user_id_follower)
  VALUES ('".$_POST["following_id"]."', '".$user_id."')
  ";
    $statement = $connect->prepare($query);
    if($statement->execute())
    {
        $sub_query = "
   UPDATE users SET followers_count = followers_count + 1 WHERE id = '".$_POST["following_id"]."'
   ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
    }
    else {
        header('HTTP/1.1 500 Internal Server error');
    }
}

if($_POST['action'] == 'unfollow')
{
    $query = "
  DELETE FROM followers
  WHERE user_id_following = '".$_POST["following_id"]."'
  AND user_id_follower = '".$user_id."'
  ";
    $statement = $connect->prepare($query);
    if($statement->execute()) {
        $sub_query = "
   UPDATE users
   SET followers_count = followers_count - 1
   WHERE id = '" . $_POST["following_id"] . "'
   ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
    }
    else {
        header('HTTP/1.1 500 Internal Server error');
    }
}

function make_follow_button($connect, $following, $follower)
{
    $query = "
 SELECT * FROM followers 
 WHERE user_id_follower = '".$follower."' 
 AND user_id_following = '".$following."'
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $total_row = $statement->rowCount();
    $output = '';
    if($total_row > 0)
    {
        $output = '<button type="button" name="follow_button" class="btn btn-custom action_button" data-action="unfollow" data-following_id="'.$following.'"> <span class="following">Following</span></button>';
    }
    else
    {
        $output = '<button type="button" name="follow_button" class="btn btn-custom-un action_button" data-action="follow" data-following_id="'.$following.'"> Follow</button>';
    }
    return $output;
}