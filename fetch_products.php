<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM products");

if (!$result) {
    die(json_encode(["status" => "error", "message" => "Database Query Failed: " . $conn->error])); // ✅ Returns JSON error response
}

$output = "";
while ($row = $result->fetch_assoc()) {
    // ✅ Properly encode product data for JavaScript
    $productData = json_encode([
        "id" => intval($row["id"]), // Ensure ID is an integer
        "name" => htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'),
        "price" => number_format(floatval($row["price"]), 2), // ✅ Ensures proper currency format
        "image" => htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'),
        "description" => htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8')
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); // ✅ Safer encoding for special characters

    $output .= "<div class='product-card'>
        <img src='image/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' class='product-img'>
        <h3 class='product-name'>" . htmlspecialchars($row['name']) . "</h3>
        <p class='product-price'><strong>₹" . $productData["price"] . "</strong></p>
        <p class='product-description'>" . htmlspecialchars($row['description']) . "</p>
        <button class='cart-btn' onclick='addToCart(" . htmlspecialchars($productData, ENT_QUOTES, 'UTF-8') . ")'>Add to Cart</button>
    </div>";
}

echo $output;
?>