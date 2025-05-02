<?php
$data = json_decode(file_get_contents("php://input"), true);

$to = "info@comfortkare.com"; // ✅ Now sending orders here
$subject = "New Order - Comfort Kare [#" . uniqid() . "]"; // ✅ Adds unique order ID
$headers = "From: orders@comfortkare.com\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = "<h2>New Order Received</h2>";
$message .= "<p><strong>Name:</strong> {$data['name']}</p>";
$message .= "<p><strong>Mobile:</strong> {$data['phone']}</p>";
$message .= "<p><strong>Address:</strong> {$data['address']}</p>";
$message .= "<h3>Ordered Items:</h3><ul>";

foreach ($data['cart'] as $item) {
    $message .= "<li>{$item['name']} - ₹{$item['price']}</li>";
}
$message .= "</ul>";

// ✅ Include transaction ID if payment is completed
if (!empty($data['transaction_id'])) {
    $message .= "<h3>Payment Details</h3>";
    $message .= "<p><strong>Transaction ID:</strong> {$data['transaction_id']}</p>";
}

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
?><?php
$data = json_decode(file_get_contents("php://input"), true);

// ✅ Define recipient email
$to = "info@comfortkare.com"; 

// ✅ Set unique order subject
$subject = "New Order - Comfort Kare [#" . uniqid() . "]"; 

// ✅ Set email headers
$headers = "From: orders@comfortkare.com\r\n";
$headers .= "Reply-To: orders@comfortkare.com\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// ✅ Build email message
$message = "<h2>New Order Received</h2>";
$message .= "<p><strong>Name:</strong> {$data['name']}</p>";
$message .= "<p><strong>Mobile:</strong> {$data['phone']}</p>";
$message .= "<p><strong>Address:</strong> {$data['address']}</p>";
$message .= "<h3>Ordered Items:</h3><ul>";

foreach ($data['cart'] as $item) {
    $message .= "<li>{$item['name']} - ₹{$item['price']}</li>";
}
$message .= "</ul>";

// ✅ Include transaction ID if payment is completed
if (!empty($data['transaction_id'])) {
    $message .= "<h3>Payment Details</h3>";
    $message .= "<p><strong>Transaction ID:</strong> {$data['transaction_id']}</p>";
}

// ✅ Try sending email with error handling
if (mail($to, $subject, $message, $headers)) {
    echo json_encode(["status" => "success", "message" => "Email sent successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to send email."]);
}

// ✅ Optional: Log errors for debugging
file_put_contents("email_log.txt", "[".date('Y-m-d H:i:s')."] Attempted to send order email.\n", FILE_APPEND);
?>