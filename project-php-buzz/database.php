<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "buzz";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>
