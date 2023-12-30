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


    $chatRoomFile = "chat_room_" . strtolower($channel) . ".php"; // Adjust the filename pattern based on your implementation
    if (file_exists($chatRoomFile)) {
        include $chatRoomFile;
        exit();
    } else {
        echo "Chat room not available for the selected sport.";
        exit();
    }
}
?>
