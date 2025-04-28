<?php
include 'db_connect.php';

$sql = "SELECT stars, created_at FROM ratings ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>⭐ " . $row["stars"] . " stars - " . $row["created_at"] . "</p>";
    }
} else {
    echo "No ratings yet!";
}

$conn->close();
?>