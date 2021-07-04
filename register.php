<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPS Tracker | Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="image/map.png" sizes="128x128">
    <link rel="stylesheet" href="css/style.css">
</head>
<?php 
    session_start();
    if($_SESSION != null){
        header("location:main.php");
    }

    if($_SERVER['HTTPS']!="on") {
    $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location:$redirect");
    }
?>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="image/map.png" id="icon"
                    alt="User Icon" style="height: 100px; width: auto;" />
            </div>

            <!-- Login Form -->
            <form autocomplete="off" method="POST" action="api/register_pro.php">
                <input type="text" name="nama" class="fadeIn second" placeholder="nama" required="">
                <input type="email" id="login" class="fadeIn third" name="email" placeholder="email" required>
                <input type="password" id="password" class="fadeIn fourth" name="password" placeholder="password"
                    required>
                <input type="submit" class="fadeIn fifth" value="Register"><br>
                <a href="index.php">Login?</a>
            </form>
        </div>
    </div>



    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>