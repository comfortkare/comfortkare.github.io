<?php
session_start();
$orderCart = isset($_SESSION["orderSummary"]) ? json_decode($_SESSION["orderSummary"], true) : [];

echo "<h2>Order Confirmation</h2>";

if (empty($orderCart)) {
    echo "<p>No items in your order.</p>";
} else {
    echo "<div class='order-details'>";
    foreach ($orderCart as $item) {
        echo "<div class='order-item'>";
        echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
        echo "<p><strong>₹" . number_format($item['price'], 2) . "</strong></p>";
        echo "</div>";
    }
    echo "</div>";
    echo "<p>Thank you for your purchase! Your order has been successfully placed.</p>";
}
?>