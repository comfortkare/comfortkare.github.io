<?php
include 'db_connect.php';

// ✅ Verify database connection before querying
if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// ✅ Secure query execution with error handling
$result = $conn->query("SELECT * FROM products");

if (!$result) {
    die(json_encode(["status" => "error", "message" => "Database Query Failed: " . $conn->error]));
}

// ✅ Ensure products exist before looping
if ($result->num_rows == 0) {
    die(json_encode(["status" => "error", "message" => "No products found in database."]));
}

$output = "";
while ($row = $result->fetch_assoc()) {
    // ✅ Fix image path handling (removes leading `/` and ensures file exists)
    $imagePath = !empty($row["image"]) && file_exists(__DIR__ . "/image/" . $row["image"]) 
                 ? "image/" . htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8') 
                 : "image/default.jpg"; // ✅ Fallback image if missing

    // ✅ JSON-encode product data correctly
    $productData = json_encode([
        "id" => intval($row["id"]),
        "name" => htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'),
        "price" => floatval($row["price"]), // ✅ Keep numeric for consistency
        "image" => $imagePath,
        "description" => htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8')
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // ✅ Build product card
    $output .= "<div class='product-card'>
        <img src='$imagePath' alt='" . htmlspecialchars($row['name']) . "' class='product-img'>
        <h3 class='product-name'>" . htmlspecialchars($row['name']) . "</h3>
        <p class='product-price'><strong>₹" . number_format(floatval($row['price']), 2) . "</strong></p>
        <p class='product-description'>" . htmlspecialchars($row['description']) . "</p>
        <button class='cart-btn' onclick='addToCart(" . htmlspecialchars($productData, ENT_QUOTES, 'UTF-8') . ")'>Add to Cart</button>
    </div>";
}

// ✅ Return final product output
echo $output;
?>