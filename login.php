<?php

include("database_connection.php");

//check if user logged in
if(isset($_COOKIE["user_id"]))
{
    header("location:index.php");
}

$message = '';

if(isset($_POST["login"]))
{
    if(empty($_POST["user_name"]) || empty($_POST["user_password"]))
    {
        $message = "<div class='alert alert-danger'>Both Fields are required</div>";
    }
    else
    {
        $query = "
  SELECT * FROM users
  WHERE name = :user_name
  ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                'user_name' => $_POST["user_name"]
            )
        );
        $count = $statement->rowCount();
        if($count > 0)
        {
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                if($_POST["user_password"] == $row["pass"])
                {
                    setcookie("user_id", $row["name"] . "," . $row["id"], time()+3600);
                    header("location:index.php");
                }
                else
                {
                    $message = '<div class="alert alert-danger">Wrong Password</div>';
                }
            }
        }
        else
        {
            $message = "<div class='alert alert-danger'>Wrong User Name</div>";
        }
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Follow User Site</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<br />
<div class="container">
    <h2 align="center">Login</h2>
    <br />
    <div class="panel panel-default">


        <div class="panel-body">
            <span><?php echo $message; ?></span>
            <form method="post">
                <div class="form-group">
                    <label>User Name</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="user_password" id="user_password" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="submit" name="login" id="login" class="btn btn-info" value="Login" />
                </div>
            </form>
        </div>
    </div>
    <br />
</div>
</body>
</html>