<?php
require_once "database.php";

if (isset($_GET["sport"])) {
    $sport = $_GET["sport"];

    
    $sql = "SELECT users.full_name, chat_messages.message
            FROM chat_messages
            JOIN users ON chat_messages.user_id = users.id
            WHERE chat_messages.sport = ? 
            ORDER BY chat_messages.timestamp ASC
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sport);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>{$row['full_name']}</strong>: {$row['message']}</p>";
    }
}
?>
