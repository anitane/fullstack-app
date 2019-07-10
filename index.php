<?php
if(isset($_COOKIE["user_id"])) {
        ?>
    <!DOCTYPE html>
    <html>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        .btn-custom-un {
            color: orange;
            background-color: floralwhite;
            border-color: #483737;
        }

        .btn-custom  {color: green;
            background-color: floralwhite;
            border-color: #483737;
        }

        .btn-custom:hover span {
            display:none
        }
        .btn-custom:hover:before {
            color: red;
            background-color: floralwhite;
            border-color: #483737;
            content:"Unfollow"}

        body {background-color: lightblue;}
        h1   {color: blue;}
        p    {color: black;}
    </style>
    <body>
    <br />
    <div class="container">
        <br />
        <div align="right">
            <a href="logout.php">Logout</a>
        </div>
        <br />
        <?php
        if(isset($_COOKIE["user_id"]))
        {
            $pieces = explode(",", $_COOKIE["user_id"]);
            $user_name = $pieces[0];
            $user_id = $pieces[1];
            echo '<h2 align="center">Welcome,' . $user_name . '</h2>';
            echo '<h2 align="center">Choose users to follow </h2>';
        }
        ?>

    </div>
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="user_list"></div>
            </div>
        </div>
    </div>
    </body>
    </html>

    <script type="text/javascript" src="js_funcs.js"></script>

<?php } else { ?>
        <p> Must be signed in </p>
    <br />
    <div align="center">
        <a href="login.php">Login</a>
    </div>
    <br />
        <?php
    }
?>