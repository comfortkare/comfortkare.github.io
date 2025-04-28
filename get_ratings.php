<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include 'db_connect.php';

// Fetch all ratings
$sql = "SELECT stars FROM ratings";
$result = $conn->query($sql);

$ratings = [];
$totalStars = 0;
$totalRatings = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ratings[] = $row["stars"];
        $totalStars += $row["stars"];
        $totalRatings++;
    }
}

// Calculate the average rating
$averageRating = $totalRatings > 0 ? round($totalStars / $totalRatings, 2) : 0;

// Return JSON response
echo json_encode([
    "status" => "success",
    "total_ratings" => $totalRatings,
    "average_rating" => $averageRating,
    "ratings" => $ratings
]);

$conn->close();
?>