<?php
// upload_brochure.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['brochure-file'])) {
    $target_dir = "brochure/";
    $target_file = $target_dir . basename($_FILES["brochure-file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a PDF
    if ($fileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["brochure-file"]["size"] > 5000000) { // 5MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Attempt to upload file
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["brochure-file"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["brochure-file"]["name"])) . " has been uploaded.";
            // Optionally, delete the old brochure or update the database if required.
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
