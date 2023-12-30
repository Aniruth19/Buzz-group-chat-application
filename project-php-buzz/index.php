<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    
    header("Location: login.php");
    exit(); 
}

require_once "database.php";


$user_id = $_SESSION["user_id"];


if (isset($_GET["channel"])) {
    $channel = $_GET["channel"];

 
    $sql = "INSERT INTO user_sport_preferences (user_id, sport) VALUES (?, ?) ON DUPLICATE KEY UPDATE sport = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $channel, $channel);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport selection page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .carousel-caption {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .carousel-item {
            height: 100vh;
        }

        .carousel-inner {
            height: 100vh;
        }

        .orange-button {
        background: linear-gradient(to right, rgb(255, 204, 0), orange, rgb(255, 204, 0));
        color: #000; /* Black font color */
        padding: 10px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .quotes {
            padding: 10px;
            background-color: rgba(14, 13, 13, 0.3);
            color: #fff;
            border-radius: 10px;
        }

    .logout-button {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 2; /* Ensure the button is in front of the carousel */
    }
    .heading {
        position: absolute;
        top: 20px;
        left: 120px;
        z-index: 1; 
        color: #FFD700; 
        text-shadow: 2px 2px 2px #333;
        font-size: 30px;
    }
</style>

    </style>
</head> 
<body>
    <h1 class="heading">⚡BUZZ</h1>
    <a href="logout.php" class="btn btn-warning logout-button">Logout</a>

    <div class="carousel-item active">
    <img src="football.jpg" class="d-block w-100" alt="Football">
    <div class="carousel-caption d-none d-md-block">
        <a class="orange-button" href="update_sport.php?channel=football"><strong>FOOTBALL</strong></a>
        <p class="quotes"><strong>"Football is more than just a game, it's a way of life and a universal language." — Pelé</strong></p>
    </div>
</div>

    <div id="mycarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="football.jpg" class="d-block w-100" alt="Football">
                <div class="carousel-caption d-none d-md-block">
                    <a class="orange-button" href="update_sport.php?channel=football"><strong>FOOTBALL</strong></a>
                    <p class="quotes"><strong>"Football is more than just a game, it's a way of life and a universal language." — Pelé</strong></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="cricket.jpg" class="d-block w-100" alt="Cricket">
                <div class="carousel-caption d-none d-md-block">
                    <a class="orange-button" href="update_sport.php?channel=cricket"><strong>CRICKET</strong></a>
                    <p class="quotes"><strong>"Cricket is a game that people play for the pride and honor of their country." — Rahul Dravid</strong></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="basketball.jpg" class="d-block w-100" alt="Basketball">
                <div class="carousel-caption d-none d-md-block">
                    <a class="orange-button" href="update_sport.php?channel=basketball"><strong>BASKETBALL</strong></a>
                    <p class="quotes"><strong>"The strength of the team is each individual member. The strength of each member is the team." — Phil Jackson</strong></p>
                </div>
            </div>
        </div>


        <a class="carousel-control-prev" href="#mycarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Prev</span>
        </a>
        <a class="carousel-control-next" href="#mycarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" ariahidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
