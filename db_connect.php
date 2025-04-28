<?php
$servername = "localhost";
$username = "ck_badusha";
$password = "Mob@72107211";
$dbname = "comfortkare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>