<?php
session_start();
require_once "database.php";

if (isset($_POST["sport"]) && isset($_POST["message"])) {
    $user_id = $_SESSION["user_id"];
    $sport = $_POST["sport"];
    $message = $_POST["message"];

    $sql = "INSERT INTO chat_messages (user_id, sport, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $sport, $message);
    $stmt->execute();
}
?>
