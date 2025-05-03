$paypal_data = [
    "payer_name" => $_SESSION["order"]["name"],
    "payer_email" => $_SESSION["order"]["email"],
    "payer_phone" => $_SESSION["order"]["phone"],
    "payer_address" => $_SESSION["order"]["address"]
];