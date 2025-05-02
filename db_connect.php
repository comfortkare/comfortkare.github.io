<?php
$conn = new mysqli("localhost", "comfortkare_admin", "Mob@72107211", "comfortkare");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
} else {
    echo "Connected Successfully!";
}
?>