<?php
include 'db_connect.php'; // ✅ Ensure this file contains the correct database connection

// ✅ Check if cart is empty or not
if (!isset($_POST['cart']) || empty($_POST['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty.']);
    exit;
}

// ✅ Decode cart from POST data
$cart = json_decode($_POST['cart'], true);

// ✅ Validate total price is provided in the POST request
$totalPrice = isset($_POST['total_price']) ? $_POST['total_price'] : 0;
if ($totalPrice <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid total price.']);
    exit;
}

// ✅ Start transaction
$conn->begin_transaction();

try {
    // ✅ Insert the order details into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status, created_at) VALUES (?, ?, 'Pending', NOW())");
    $userId = 1; // Replace with actual logged-in user ID or session value
    $stmt->bind_param("id", $userId, $totalPrice);
    $stmt->execute();

    // ✅ Get the last inserted order ID
    $orderId = $stmt->insert_id;

    // ✅ Insert the individual cart items into the order_items table
    foreach ($cart as $item) {
        $productId = $item['id']; // Ensure you send the product ID from cart.js
        $quantity = 1; // Can be adjusted to capture
