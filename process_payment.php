<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : "";
    $phone = htmlspecialchars($_POST["phone"]);
    $address = htmlspecialchars($_POST["address"]);
    $payment_method = htmlspecialchars($_POST["payment_method"]);

    // ✅ Store customer details in session before payment
    $_SESSION["order"] = [
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "address" => $address,
        "payment_method" => $payment_method
    ];

    // ✅ Redirect to payment gateway
    header("Location: payment_gateway.php");
    exit;
}
?>