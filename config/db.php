<?php
$host = "localhost";
$user = "root";
$password = ""; // your DB password
$dbname = "home_decor"; // change this to your actual DB name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
