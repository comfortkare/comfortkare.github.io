<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stars = $_POST["stars"];

    $sql = "INSERT INTO ratings (stars) VALUES ('$stars')";

    if ($conn->query($sql) === TRUE) {
        echo "Rating submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>