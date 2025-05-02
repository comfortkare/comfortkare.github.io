<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM products");

if (!$result) {
    die(json_encode(["status" => "error", "message" => "Database Query Failed: " . $conn->error])); // ✅ Returns JSON error response
}

$output = "";
while ($row = $result->fetch_assoc()) {
    // ✅ Ensure all data is properly formatted
    $productData = json_encode([
        "id" => intval($row["id"]),
        "name" => htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'),
        "price" => number_format(floatval($row["price"]), 2),
        "image" => ltrim(htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'), "/"), // ✅ Fix image path issue
        "description" => htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8')
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // ✅ Fix the image path issue in the shop display
    $output .= "<div class='product-card'>
        <img src='image/" . ltrim(htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'), "/") . "' alt='" . htmlspecialchars($row['name']) . "' class='product-img'>
        <h3 class='product-name'>" . htmlspecialchars($row['name']) . "</h3>
        <p class='product-price'><strong>₹" . $productData["price"] . "</strong></p>
        <p class='product-description'>" . htmlspecialchars($row['description']) . "</p>
        <button class='cart-btn' onclick='addToCart(" . htmlspecialchars($productData, ENT_QUOTES, 'UTF-8') . ")'>Add to Cart</button>
    </div>";
}

echo $output;
?>