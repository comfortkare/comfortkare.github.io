<?php
if (isset($_POST['rating'])) {
    $rating = $_POST['rating'];

    // Example code: store the rating in a file or database.
    // You can either use a file or database to keep track of ratings.
    
    // Example: Store in a file (ratings.json)
    $file = 'ratings.json';
    $ratings = json_decode(file_get_contents($file), true);

    // Increment the corresponding rating count
    $ratings[$rating - 1] += 1;

    // Save the updated ratings back to the file
    file_put_contents($file, json_encode($ratings));
}
?>
