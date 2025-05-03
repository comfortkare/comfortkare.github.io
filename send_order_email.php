<?php
$data = json_decode(file_get_contents("php://input"), true);

// ✅ Validate input data before sending email
if (!isset($data['name']) || !isset($data['phone']) || !isset($data['address']) || empty($data['cart'])) {
    echo json_encode(["status" => "error", "message" => "Invalid order data received."]);
    exit;
}

// ✅ Define recipient email
$to = "info@comfortkare.com";  

// ✅ Generate unique order subject
$subject = "New Order - Comfort Kare [#" . uniqid() . "]";  

// ✅ Set email headers
$headers = "From: orders@comfortkare.com\r\n";
$headers .= "Reply-To: orders@comfortkare.com\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// ✅ Build email message
$message = "<h2>New Order Received</h2>";
$message .= "<p><strong>Name:</strong> " . htmlspecialchars($data['name']) . "</p>";
$message .= "<p><strong>Mobile:</strong> " . htmlspecialchars($data['phone']) . "</p>";
$message .= "<p><strong>Address:</strong> " . nl2br(htmlspecialchars($data['address'])) . "</p>";
$message .= "<h3>Ordered Items:</h3><ul>";

foreach ($data['cart'] as $item) {
    $message .= "<li>" . htmlspecialchars($item['name']) . " - ₹" . number_format($item['price'], 2) . "</li>";
}
$message .= "</ul>";

// ✅ Include transaction details if available
if (!empty($data['transaction_id'])) {
    $message .= "<h3>Payment Details</h3>";
    $message .= "<p><strong>Transaction ID:</strong> " . htmlspecialchars($data['transaction_id']) . "</p>";
}

// ✅ Attempt sending email & provide better error handling
if (mail($to, $subject, $message, $headers)) {
    echo json_encode(["status" => "success", "message" => "Email sent successfully!"]);
} else {
    error_log("Failed to send email: " . json_encode($data), 3, "email_log.txt"); // ✅ Logs failed attempts
    echo json_encode(["status" => "error", "message" => "Failed to send email."]);
}
?>