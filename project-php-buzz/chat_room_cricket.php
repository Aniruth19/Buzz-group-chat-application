<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

// Get the user's ID from the session
$user_id = $_SESSION["user_id"];

// Check if a sport button is clicked
if (isset($_GET["channel"])) {
    $channel = $_GET["channel"];

    // Update the user's sport preference in the database
    $sql = "INSERT INTO user_sport_preferences (user_id, sport) VALUES (?, ?) ON DUPLICATE KEY UPDATE sport = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $channel, $channel);
    $stmt->execute();
}

// Retrieve and display chat messages
$sql = "SELECT users.full_name, chat_messages.message, chat_messages.timestamp
        FROM chat_messages
        JOIN users ON chat_messages.user_id = users.id
        WHERE chat_messages.sport = 'cricket'
        ORDER BY chat_messages.timestamp ASC
        LIMIT 10";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <h1 class="heading">⚡BUZZ</h1>
    <a href="logout.php" class="btn btn-warning logout-button">Logout</a>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cricket Chat Room</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!-- Additional Styles -->
    <style>
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
        z-index: 1; /* Ensure the button is in front of the carousel */
        color: #FFD700; /* Orangish-yellow color */
        text-shadow: 2px 2px 2px #333; /* Adds a shadow with light greyish black color */
        font-size: 30px;
        }
        body {
            background-image: url(cricket\(cr\).jpg);
	        height: 100vh;
	        width: 100vw;
        }
        #chatMessages {
    background: rgba(100, 100, 100, 0.5);
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(255, 204, 0, 0.5);
    height: 400px; /* Set your desired fixed height */
    overflow-y: auto; /* Enable vertical scrolling */
    color: white;
}



#messageForm {
    margin-top: 15px;
}

#messageInput {
    border-top-left-radius: 40px;
    border-bottom-left-radius:40px;
    margin-bottom: 20px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    box-shadow: 0 0 10px rgba(255, 204, 0, 0.9);
}

.btn-primary {
    background: linear-gradient(to right, orange, rgb(255, 204, 0 ), rgb(255, 204, 0));
    height: 38px;
    border-radius: 40px;
    color: black;
}

.roomtitle {
    margin-top: 100px;
    border-radius: 10px;
    background: linear-gradient(to right, orange, rgb(255, 204, 0 ,0.9), rgb(255, 204, 0 ,0.9));
}
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="roomtitle text-center">Cricket Chat Room</h1>

        <!-- Display the chat messages here -->
        <div id="chatMessages" class="card mt-3 p-3">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p><strong>{$row['full_name']}</strong>: {$row['message']}</p>";
            }
            ?>
        </div>

        <!-- Add a form for users to send messages -->
        <form id="messageForm" class="mt-3">
            <div class="input-group">
                <input type="text" id="messageInput" class="form-control" placeholder="Type your message...">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <!-- Add JavaScript for handling messages and updates -->
    <script>
        // Function to refresh chat messages
        function refreshChatMessages() {
            // AJAX request to get the latest messages
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Update the chat messages
                        document.getElementById("chatMessages").innerHTML = xhr.responseText;
                    }
                }
            };
            xhr.open("GET", "get_chat_messages.php?sport=cricket", true);
            xhr.send();
        }

        // Function to send a new message
        function sendMessage() {
            var messageInput = document.getElementById("messageInput").value;

            // AJAX request to send the message
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) 
                {
                    if (xhr.status === 200) 
                    {
                        // Refresh chat messages after sending the message
                        refreshChatMessages();
                    }
                }
            };
            xhr.open("POST", "send_message.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("sport=cricket&message=" + encodeURIComponent(messageInput));
        }

        // Refresh chat messages on page load
        refreshChatMessages();

        // Attach the function to the form submission
        document.getElementById("messageForm").onsubmit = function (event) {
            event.preventDefault();
            sendMessage();
            // Clear the input field after sending the message
            document.getElementById("messageInput").value = "";
        };

        // Schedule periodic refresh of chat messages (e.g., every 5 seconds)
        setInterval(refreshChatMessages, 5000);
    </script>

</body>
</html>
