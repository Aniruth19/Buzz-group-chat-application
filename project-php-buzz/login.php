<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('https://wallpapers.com/images/hd/glowing-sports-stadium-65rc2p670tr88gxa.jpg');
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 30px;
            background-color: rgba(231, 231, 231, 0.8);
            backdrop-filter: blur(2px);
        }
        .container {
            padding: 20px;
            height: 230px;
            width: 500px;
            background-color: rgba(255, 255, 255, 0.4);
            box-shadow: 8px 8px 20px rgb(13, 13, 13);
            position: relative;
            border-radius: 2%;
        }

        .form-group {
            margin: 10px 0;
        }

        .form-btn input[type="submit"] {
            background: linear-gradient(to right, orange, rgb(255, 204, 0), rgb(255, 204, 0));
            border: none;
            border-radius: 50px;
            color: white;
            font-size: 22px;
            cursor: pointer;
            padding: 10px 20px;
            margin-left: 180px;
        }
        .belowreg{
            padding-top: 10px;
        }
        .context {
            color: white;
            text-shadow: 2px 2px 2px black; 
        }
        .heading {
            margin-left: 161px;
            color: #FFD700; 
            text-shadow: 2px 2px 2px #333; 
            font-size: 40px;
        }
    </style>
</head>
<body>
<header>
    <h1 class="heading">⚡BUZZ</h1>
    <h3 class="context"><strong>Unite Fans, Chat Sports, Share Victory</strong></h3>
</header>
<div class="container">
    <?php
    if (isset($_POST["login"])) {
       $email = $_POST["email"];
       $password = $_POST["password"];
        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"]; 
                $_SESSION["user"] = "yes";
                header("Location: index.php");
                die();
            } else {
                echo "<div class='alert alert-danger'>Password does not match</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Email does not match</div>";
        }        
    }
    ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <input type="email" placeholder="Enter Email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Enter Password" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
    </form>
    <div class="belowreg"><p>Not registered yet? <a href="registration.php">Register Here</a></p></div>
</div>
</body>
</html>
