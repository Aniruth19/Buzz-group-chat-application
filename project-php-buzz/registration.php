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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡BUZZ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .heading {
    color: #FFD700; /* Orangish-yellow color */
    text-shadow: 2px 2px 2px #333; /* Adds a shadow with light greyish black color */
    font-size: 40px;
       }

        body {
            background-image: url('https://wallpapers.com/images/hd/glowing-sports-stadium-65rc2p670tr88gxa.jpg');
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 30px;
            background-color: rgba(231, 231, 231, 0.8); /* Added background opacity */
            backdrop-filter: blur(2px); /* Add blur to the background */
        }

        header {
            width: 100%;
            display: flex;
            background: transparent;
            backdrop-filter: blur(3px);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .container {
            padding: 20px;
            height: 350px;
            width: 500px;
            background-color: rgba(255, 255, 255, 0.2);  /* Transparent yellowish background */
            box-shadow: 8px 8px 20px rgb(13, 13, 13);
            position: relative;
            overflow: hidden;
            border-radius: 2%;
        }

        .form-btn {
            text-align: center;
        }

        .form-btn input[type="submit"] {
            background: linear-gradient(to right, orange, rgb(255, 204, 0), rgb(255, 204, 0));
            border: none;
            border-radius: 50px;
            color: rgba(0, 0, 0, 0.7); 
            font-size: 22px;
            cursor: pointer;
            padding: 10px 20px;
            
        }
        .belowreg{
            padding-top: 10px;
        }
        .context {
    color: white; /* White text color */
    text-shadow: 2px 2px 2px black; /* Adds a black shadow to the text */
}


    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1 class="heading">⚡BUZZ</h1>
        <h3 class="context"><strong>Unite Fans, Chat Sports, Share Victory</strong></h3>
    </header>

    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();

            if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Password does not match");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                } else {
                    die("Something went wrong");
                }
            }
        }
        ?>

        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>

        <div>
            <div class="belowreg"><p>Already Registered? <a href="login.php">Login Here</a></p></div>
        </div>
    </div>
</body>
</html>
