<?php
$host = getenv("MYSQL_HOST") ?: "localhost";
$username = getenv("MYSQL_USERNAME") ?: "root";
$password = getenv("MYSQL_PASSWORD") ?: "";
$database = getenv("MYSQL_DATABASE") ?: "bb";

$conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Errore: " . $conn->connect_error);
    }

?>