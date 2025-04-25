<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // Collect form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];
        $message = $_POST['message'];
        $product_details = $_POST['product_details'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $product_comments = $_POST['product_comments'] ?? '';

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'comfortkare.team@gmail.com';  // your Gmail
        $mail->Password   = 'kaul qchw iqip dero';     // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Email Headers
        $mail->setFrom($email, $name);
        $mail->addAddress('comfortkare.team@gmail.com'); // Where you want to receive emails

        $mail->isHTML(true);
        $mail->Subject = "Customer Feedback - $type";

        // Email Body
        $body = "<h2>New $type Received</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Type:</strong> $type</p>
        <p><strong>Message:</strong><br>$message</p>";

        if ($type === "Enquiry") {
            $body .= "<hr><p><strong>Product Details:</strong> $product_details</p>
            <p><strong>Quantity:</strong> $quantity</p>
            <p><strong>Comments:</strong><br>$product_comments</p>";
        }

        $mail->Body = $body;

        $mail->send();
        echo "<script>alert('Email sent successfully!'); window.location.href = 'thank-you.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href = 'feedback.html';</script>";
    }
}
?>
