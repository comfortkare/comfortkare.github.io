<?php
$servername = "localhost";
$username = "comfortkare_admin";
$password = "Mob@72107211";
$database = "comfortkare";

// Create connection with error handling
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Fetch products securely
$result = $conn->query("SELECT * FROM products");
if (!$result) {
    die("Error Fetching Products: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop – Comfort Kare</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
    <style>
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .product-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            width: 250px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .product-card img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .product-card h3 {
            margin: 10px 0 5px;
            font-size: 18px;
        }

        .product-card p {
            margin: 5px 0;
            font-size: 15px;
        }

        .product-card button {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }

        .product-card button:hover {
            background-color: #005fa3;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Shop Our Products</h2>

<div class="product-grid">
  <?php while($row = $result->fetch_assoc()) { ?>
    <div class="product-card">
      <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
      <h3><?php echo htmlspecialchars($row['name']); ?></h3>
      <p><strong>₹<?php echo number_format($row['price'], 2); ?></strong></p>
      <p><?php echo htmlspecialchars($row['description']); ?></p>
      <button>Add to Cart</button>
    </div>
  <?php } ?>
</div>

<?php $conn->close(); ?>

</body>
</html>