<?php

//database_connection.php

$connect = new PDO('mysql:host=localhost;dbname=testing', 'root', 'password');

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "testing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>