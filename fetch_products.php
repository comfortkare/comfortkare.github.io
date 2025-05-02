<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM products");

if (!$result) {
    die("Database Query Failed: " . $conn->error);
}

$output = "";
while ($row = $result->fetch_assoc()) {
    // Properly encode product data for JavaScript
    $productData = json_encode([
        "id" => $row["id"],
        "name" => htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'),
        "price" => floatval($row["price"]), // ✅ Ensuring it's a numeric value
        "image" => htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'),
        "description" => htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8')
    ], JSON_HEX_APOS | JSON_HEX_QUOT); // ✅ Protect against encoding issues

    $output .= "<div class='product-card'>
        <img src='image/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' class='product-img'>
        <h3 class='product-name'>" . htmlspecialchars($row['name']) . "</h3>
        <p class='product-price'><strong>₹" . number_format($row['price'], 2) . "</strong></p>
        <p class='product-description'>" . htmlspecialchars($row['description']) . "</p>
        <button class='cart-btn' onclick='addToCart($productData)'>Add to Cart</button>
    </div>";
}

echo $output;
?>