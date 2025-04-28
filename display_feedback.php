<?php
header("Content-Type: text/html; charset=UTF-8");
include 'db_connect.php';

$result = $conn->query("SELECT * FROM feedback ORDER BY created_at DESC");

if ($result->num_rows > 0) {
    echo "<h2>Customer Feedback</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0' style='width:100%; border-collapse: collapse;'>
            <tr style='background: #0077cc; color: white;'>
                <th>Name</th><th>Comments</th><th>Submitted On</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['comments']) . "</td>
                <td>" . $row['created_at'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No feedback available.</p>";
}

$conn->close();
?>