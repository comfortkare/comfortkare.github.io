<?php
// Fetching rating counts (You can replace this with database or file-based storage)
$ratings = [5, 2, 3, 7, 12]; // Example: ratings counts for 1-star, 2-star, 3-star, 4-star, 5-star

// Calculate total votes
$totalVotes = array_sum($ratings);

// Initialize percentage array
$percentages = [];
foreach ($ratings as $rating => $count) {
    $percentages[$rating] = ($totalVotes > 0) ? round(($count / $totalVotes) * 100, 1) : 0;
}

// Return the ratings and percentage data as JSON
echo json_encode([
    'ratings' => $ratings,
    'percentages' => $percentages,
    'totalVotes' => $totalVotes
]);
?>
